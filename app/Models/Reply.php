<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Reply extends Model
{
    /** @use HasFactory<\Database\Factories\ReplyFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function parentReply(): BelongsTo
    {
        return $this->belongsTo(Reply::class);
    }

    public function parentReplyRecursive(): BelongsTo
    {
        return $this->parentReply()->with('parentReplyRecursive');
    }

    public function childReplies(): HasMany
    {
        return $this->hasMany(Reply::class, 'parent_reply_id');
    }

    public function childRepliesRecursive(): HasMany
    {
        return $this->childReplies()->with('childRepliesRecursive');
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
}
