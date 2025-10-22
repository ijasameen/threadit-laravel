<?php

namespace App\Models;

use App\PostStatus;
use App\PostVisibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPublic(): bool {
        return $this->visibility === PostVisibility::PUBLIC;
    }

    public function isPrivate(): bool {
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
