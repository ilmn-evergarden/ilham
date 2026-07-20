<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'issuer',
        'issue_date',
        'expiration_date',
        'credential_id',
        'credential_url',
        'image',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'issue_date'      => 'date',
            'expiration_date' => 'date',
        ];
    }

    /** Certificate belongs to a User. */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Whether the certificate has no expiration date (lifetime). */
    public function isLifetime(): bool
    {
        return $this->expiration_date === null;
    }

    /** Whether the certificate is currently valid. */
    public function isExpired(): bool
    {
        return $this->expiration_date !== null && $this->expiration_date->isPast();
    }
}
