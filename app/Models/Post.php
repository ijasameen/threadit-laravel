<?php

namespace App\Models;

use App\PostStatus;
use App\PostVisibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function upVotes(): int
    {
        return $this->votes->where('value', '>', 0)->count();
    }

    public function downVotes(): int
    {
        return $this->votes->where('value', '<', 0)->count();
    }

    public function getVoteForUser(User $user): ?Vote
    {
        return $this->votes->where('user_id', '=', $user->id)->first();
    }

    public function isPublic(): bool
    {
        return $this->visibility === PostVisibility::PUBLIC;
    }

    public function isPrivate(): bool
    {
        return $this->visibility === PostVisibility::PRIVATE;
    }

    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
            'visibility' => PostVisibility::class,
            'published_at' => 'datetime',
        ];
    }
}
