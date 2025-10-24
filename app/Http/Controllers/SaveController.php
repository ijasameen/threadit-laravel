<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Save;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SaveController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'savable_type' => ['required', 'string', Rule::in(['post'])],
            'savable_id' => ['required', 'integer'],
            'saved' => ['required', 'boolean'],
        ]);

        $savable_model = match ($request->savable_type) {
            'post' => Post::class,
        };

        $user = Auth::user();
        $savable = $savable_model::find($request->savable_id);

        if (! $user || ! $savable) {
            abort(404);
        }

        $save = Save::where('user_id', '=', $user->id)
            ->where('savable_id', '=', $savable->id)
            ->where('savable_type', '=', $savable_model)->first();

        if ($request->saved && ! $save) {
            $savable->saves()->create([
                'user_id' => $user->id,
            ]);

            return response()->json([
                'message' => 'saved',
                'saved' => true,
            ], 201);
        } elseif (! $request->saved && $save) {
            $save->delete();

            return response()->json([
                'message' => 'unsaved',
                'saved' => false,
            ], 200);
        } else {
            return response()->json([
                'message' => 'already '.$request->saved ? 'saved' : 'unsaved',
                'saved' => isset($save),
            ], 200);
        }
    }
}
