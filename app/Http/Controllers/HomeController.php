<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\PostStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $posts = Post::with('user')->where('status', '=', PostStatus::PUBLISHED)->orderBy('published_at', 'DESC')->get();
        $user = Auth::user();

        return view('home', ['posts' => $posts, 'user' => $user]);
    }
}
