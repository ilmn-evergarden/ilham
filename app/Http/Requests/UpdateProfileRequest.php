<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Only authenticated users may update profiles.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for the portfolio profile.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'profession' => ['nullable', 'string', 'max:255'],
            'bio'        => ['nullable', 'string'],
            'photo'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'cv'         => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'phone'      => ['nullable', 'string', 'max:30'],
            'location'   => ['nullable', 'string', 'max:255'],
            'github'     => ['nullable', 'url', 'max:255'],
            'linkedin'   => ['nullable', 'url', 'max:255'],
            'instagram'  => ['nullable', 'url', 'max:255'],
            'website'    => ['nullable', 'url', 'max:255'],
        ];
    }

    /**
     * Custom attribute names for error messages.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'profession' => 'Profesi',
            'bio'        => 'Bio',
            'photo'      => 'Foto Profil',
            'cv'         => 'File CV',
            'phone'      => 'Nomor Telepon',
            'location'   => 'Lokasi',
            'github'     => 'GitHub',
            'linkedin'   => 'LinkedIn',
            'instagram'  => 'Instagram',
            'website'    => 'Website',
        ];
    }
}
