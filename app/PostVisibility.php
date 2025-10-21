<?php

namespace App;

enum PostVisibility: string
{
    case PUBLIC = 'public';
    case PRIVATE = 'private';

    public function label(): string
    {
        return match ($this) {
            self::PUBLIC => 'Public',
            self::PRIVATE => 'Private',
        };
    }
}
