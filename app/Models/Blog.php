<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'thumbnail',
        'excerpt',
        'content',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /**
     * Auto-generate slug from title before creating if not set.
     */
    protected static function booted(): void
    {
        static::creating(function (Blog $blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    /** Blog belongs to a User. */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Scope: only published articles, ordered newest first. */
    public function scopePublished($query)
    {
        return $query->where('status', 'Published')
                     ->whereNotNull('published_at')
                     ->orderByDesc('published_at');
    }

    public function isPublished(): bool
    {
        return $this->status === 'Published' && $this->published_at !== null;
    }
}
