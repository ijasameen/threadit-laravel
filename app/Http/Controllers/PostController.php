<?php

namespace App\Http\Controllers;

use App\PostStatus;
use App\PostVisibility;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function create(string $username)
    {
        $user = Auth::user();

        if (! $user || $user->username !== $username) {
            return redirect("/u/$user->username/posts/create");
        }

        return view('post.create', ['user' => $user]);
    }

    public function store(Request $request)
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

        return redirect('/');
    }
}
