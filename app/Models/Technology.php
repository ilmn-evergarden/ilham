<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Technology extends Model
{
    protected $fillable = [
        'name',
        'icon',
    ];

    /**
     * Technology belongs to many Projects through project_technologies pivot.
     * The relationship is defined here to enable the "still in use" guard in the controller.
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_technologies');
    }
}
