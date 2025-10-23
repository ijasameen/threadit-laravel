<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\PostStatus;
use App\PostVisibility;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function show(?string $username, int $id, string $slug): View|RedirectResponse
    {
        $post = Post::with('replies.votes')->with('votes')->find($id);
        $owner = User::find($post->user_id);

        if (! $post || ! $owner) {
            abort(404);
        } elseif ($post->slug !== $slug || $username !== $owner->username) {
            return redirect(route('posts.show', ['username' => $owner->username, 'id' => $id, 'slug' => $post->slug]));
        }

        $replies = $post->replies()
            ->whereNull('parent_reply_id')
            ->with('childRepliesRecursive.user')
            ->orderBy('created_at', 'DESC')
            ->get();

        $back_url = route('home');

        return view('post.show', [
            'post' => $post,
            'user' => Auth::user(),
            'replies' => $replies,
            'back_url' => $back_url,
        ]);
    }

    public function create(Request $request, string $username): View|RedirectResponse
    {
        $user = Auth::user();

        if (! $user || $user->username !== $username) {
            return redirect("/u/$user->username/posts/create");
        }

        $cancel_url = back()->getTargetUrl();
        $cancel_url = $cancel_url == $request->fullUrl() ? route('home') : $cancel_url;

        return view('post.create', ['user' => $user, 'cancel_url' => $cancel_url]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'summary' => ['required', 'string', 'max:300'],
            'body' => ['string', 'nullable'],
        ]);

        $data = [
            'summary' => $request->summary,
            'body' => $request->body,
            'slug' => Str::slug($request->summary, '50'),
            'status' => isset($request->is_publish) ? PostStatus::PUBLISHED : PostStatus::DRAFT,
            'visibility' => PostVisibility::PUBLIC,
            'published_at' => isset($request->is_publish) ? new DateTime : null,
        ];

        $post = Auth::user()->posts()->create($data);

        // TODO: posted message
        return to_route('home');
    }

    public function edit(Request $request, string $username, int $id, ?string $slug = null): View|RedirectResponse
    {
        $user = Auth::user();
        $post = Post::find($id);

        if (! $post) {
            abort(404);
        } elseif ($post->user_id !== $user->id) {
            // TODO: redirect to home with a unauthorized message
            abort(403, 'You are not authorized to edit this post.');
        } elseif ($user->username !== $username) {
            return to_route('posts.edit', ['username' => $user->username, 'id' => $id, 'slug' => $post->slug]);
        } elseif ($post->slug !== $slug) {
            // TODO: Show a message that the title/summary was changed
            return to_route('posts.edit', ['username' => $username, 'id' => $post->id, 'slug' => $post->slug]);
        }

        $cancel_url = back()->getTargetUrl();
        $cancel_url = $cancel_url == $request->fullUrl() ? route('home') : $cancel_url;

        return view('post.edit', ['post' => $post, 'user' => $user, 'cancel_url' => $cancel_url]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $post = Post::find($request->id);

        if (! $post) {
            abort(500);
        } elseif ($post->user_id !== $user->id) {
            // TODO: redirect to home with a unauthorized message
            abort(403, 'You are not authorized to edit this post.');
        }

        $request->validate([
            'summary' => ['required', 'string', 'max:300'],
            'body' => ['string', 'nullable'],
        ]);

        $is_public = (bool) $request->is_public;
        $post->summary = $request->summary;
        $post->body = $request->body;
        $post->visibility = $is_public ? PostVisibility::PUBLIC : PostVisibility::PRIVATE;
        $post->save();

        // TODO: edited message
        return to_route('home');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $post = Post::find($request->id);

        if (! $post) {
            abort(500);
        } elseif ($post->user_id !== $user->id) {
            // TODO: redirect to home with a unauthorized message
            abort(403, 'You are not authorized to delete this post.');
        }

        $post->delete();

        // TODO: deleted message
        return to_route('home');
    }
}
