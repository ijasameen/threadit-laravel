<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::middleware('guest')->group(function () {
    Route::get('signup', [RegisteredUserController::class, 'create'])
        ->name('signup');

    Route::post('signup', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);

    Route::get('{username}/posts/create', [PostController::class, 'create'])->name('posts.create');

    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::patch('posts', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('{username}/posts/edit/{id}/{slug?}', [PostController::class, 'edit'])->name('posts.edit');
    Route::get('{username}/replies/edit/{id}', [ReplyController::class, 'edit'])->name('replies.edit');

    Route::post('replies', [ReplyController::class, 'store'])->name('replies.store');
    Route::patch('replies', [ReplyController::class, 'update'])->name('replies.update');
    Route::delete('replies', [ReplyController::class, 'destroy'])->name('replies.destroy');

    Route::post('api/votes', [VoteController::class, 'store'])->name('votes.store');
});

Route::get('{username}/posts/{id}/{slug?}', [PostController::class, 'show'])->name('posts.show');
Route::get('{username}/replies/{id}', [ReplyController::class, 'show'])->name('replies.show');
