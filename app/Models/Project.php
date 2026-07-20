<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'thumbnail',
        'github_url',
        'demo_url',
        'status',
        'start_date',
        'end_date',
        'featured',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date'   => 'date',
            'featured'   => 'boolean',
        ];
    }

    /**
     * Auto-generate slug from title before creating.
     */
    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    /** Project belongs to a User. */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Project has many gallery images, ordered by sort_order. */
    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order')->orderBy('id');
    }

    /** Project belongs to many Technologies through project_technologies. */
    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class, 'project_technologies');
    }

    /** Convenience: array of status options used in forms & validation. */
    public static function statuses(): array
    {
        return ['Development', 'Production', 'Maintenance', 'Completed'];
    }

    /** Badge colour map for status. */
    public static function statusColour(string $status): string
    {
        return match ($status) {
            'Development'  => 'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-400',
            'Production'   => 'bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400',
            'Maintenance'  => 'bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-400',
            'Completed'    => 'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400',
            default        => 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400',
        };
    }
}
