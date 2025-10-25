<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\PostStatus;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $posts = Post::with('user')
            ->with('replies')
            ->with('votes.user')
            ->where('status', '=', PostStatus::PUBLISHED)
            ->orderBy('published_at', 'DESC')
            ->get();

        return view('home', ['posts' => $posts]);
    }
}
