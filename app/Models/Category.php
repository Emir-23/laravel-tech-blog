<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Bu kategoriye ait yazılar (category_post pivot tablosu üzerinden).
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'category_post')->withTimestamps();
    }
}
