<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:255'],
            'slug'         => ['required', 'string', 'max:255', Rule::unique('blogs', 'slug')],
            'excerpt'      => ['required', 'string'],
            'content'      => ['required', 'string'],
            'thumbnail'    => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status'       => ['required', Rule::in(['Draft', 'Published'])],
            // published_at required only when publishing
            'published_at' => ['nullable', 'date', 'required_if:status,Published'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title'        => 'Judul',
            'slug'         => 'Slug',
            'excerpt'      => 'Excerpt',
            'content'      => 'Konten',
            'thumbnail'    => 'Thumbnail',
            'status'       => 'Status',
            'published_at' => 'Tanggal Publish',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'published_at.required_if' => 'Tanggal Publish wajib diisi saat status Published.',
        ];
    }
}
