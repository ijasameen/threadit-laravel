<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Save extends Model
{
    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function savable(): MorphTo
    {
        return $this->morphTo();
    }
}
