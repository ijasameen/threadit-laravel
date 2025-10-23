<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReplyController extends Controller
{
    public function show($username, $id): View
    {
        $reply = Reply::with('user')->find($id);

        if (! $reply) {
            abort(404);
        } elseif ($reply->user->username !== $username) {
            redirect(route('replies.show', ['username' => $reply->user->username]));
        }

        $reply->with('post.user')->with('parentReply.user')->with('childRepliesRecursive.user');

        if ($reply->parentReply) {
            $parent_reply = $reply->parentReply;
            $back_url = route('replies.show', ['username' => $parent_reply->user->username, 'id' => $parent_reply->id]);
        } else {
            $post = $reply->post;
            $back_url = route('posts.show', ['username' => $post->user->username, 'id' => $post->id, 'slug' => $post->slug]);
        }

        $user = Auth::user();

        return view('reply.show', ['reply' => $reply, 'user' => $user, 'back_url' => $back_url]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $post = Post::find($request->post_id);
        $parent_reply = Reply::find($request->parent_reply_id);

        if (! $post) {
            abort(500);
        }

        $request->validate([
            'body' => ['required', 'string'],
        ]);

        $post->replies()->create([
            'body' => $request->body,
            'user_id' => $user->id,
            'parent_reply_id' => $parent_reply ? $parent_reply->id : null,
        ]);

        return back()->with('success');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $reply = Reply::find($request->id);

        if (! $reply) {
            abort(500);
        } elseif ($reply->user_id !== $user->id) {
            // TODO: redirect to home with a unauthorized message
            abort(403, 'You are not authorized to delete this post.');
        }

        $reply->delete();

        // TODO: deleted message
        return back()->with('success');
    }
}
