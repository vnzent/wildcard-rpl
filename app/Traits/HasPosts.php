<?php

namespace App\Traits;

use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasPosts
{
    public function posts(): HasMany
    {
        return $this->morphMany(Post::class, 'authorable');
    }
}
