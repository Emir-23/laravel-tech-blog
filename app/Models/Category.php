<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ılluminate\Database\Eloquent\Relations\HasMany;
class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
