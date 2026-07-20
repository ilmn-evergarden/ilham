<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    /**
     * Laravel's inflector maps "Education" → "education" (not "educations").
     * Explicitly set the correct table name.
     */
    protected $table = 'educations';

    protected $fillable = [
        'user_id',
        'level',
        'school_name',
        'major',
        'start_year',
        'end_year',
        'description',
    ];

    /**
     * Cast year fields to integer for clean comparisons.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_year' => 'integer',
            'end_year'   => 'integer',
        ];
    }

    /**
     * Education belongs to a User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
