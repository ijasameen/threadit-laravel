<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function store(Request $request)
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

    public function destroy(Request $request)
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
