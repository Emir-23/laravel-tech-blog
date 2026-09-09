<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'is_published',
        'published_at',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Ziyaretçi tarafında görünebilir yazılar:
     * yayında işaretli ve yayın zamanı gelmiş (veya boş = hemen yayın).
     */
    public function scopeLive(Builder $query): Builder
    {
        return $query
            ->where('is_published', true)
            ->where(function (Builder $q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Zamanlanmış ama henüz yayına girmemiş mi?
     */
    public function isScheduled(): bool
    {
        return $this->is_published
            && $this->published_at !== null
            && $this->published_at->isFuture();
    }

    /**
     * Bu yazının ait olduğu kategoriler (category_post pivot tablosu üzerinden).
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_post')->withTimestamps();
    }

    /**
     * Bu yazıyı beğenen kullanıcılar (post_user pivot tablosu üzerinden).
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_user')->withTimestamps();
    }

    /**
     * Verilen kullanıcı bu yazıyı beğenmiş mi?
     */
    public function isLikedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
