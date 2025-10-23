<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class VoteController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'votable_type' => ['required', 'string', Rule::in(['post', 'reply'])],
            'votable_id' => ['required', 'integer'],
            'vote' => ['required', 'string', Rule::in(['up', 'down'])],
        ]);

        $votable_model = match ($request->votable_type) {
            'post' => \App\Models\Post::class,
            'reply' => \App\Models\Reply::class,
        };

        $votable = $votable_model::with('votes')->find($request->votable_id);
        $vote = Vote::where('user_id', '=', $user->id)
            ->where('votable_type', '=', $votable_model)
            ->where('votable_id', '=', $request->votable_id)->first();

        $value = match ($request->vote) {
            'up' => 1,
            'down' => -1
        };

        $is_upvote = $value > 0;
        $vote_string = $is_upvote ? 'up' : 'down';
        if (! $vote) {
            $votable->votes()->create(['value' => $value, 'user_id' => $user->id]);

            return response()->json([
                'message' => 'Vote registered',
                'upvotes' => $votable->upVotes() + ($is_upvote ? 1 : 0),
                'downvotes' => $votable->downVotes() + (! $is_upvote ? 1 : 0),
                'vote' => $vote_string,
            ], 201);
        } if ($vote->value !== $value) {
            $vote->update(['value' => $value]);

            return response()->json([
                'message' => 'Vote updated',
                'upvotes' => $votable->upVotes() + $value,
                'downvotes' => $votable->downVotes() + -$value,
                'vote' => $vote_string,
            ], 200);
        } else {
            $vote->delete();

            return response()->json([
                'message' => 'Vote removed',
                'upvotes' => $votable->upVotes() - ($value > 0 ? 1 : 0),
                'downvotes' => $votable->downVotes() - ($value < 0 ? 1 : 0),
                'vote' => null,
            ], 200);
        }
    }
}
