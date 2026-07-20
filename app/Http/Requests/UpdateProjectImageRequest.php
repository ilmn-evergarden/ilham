<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectImageRequest extends FormRequest
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
            'image'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'caption'    => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'image'      => 'Gambar',
            'caption'    => 'Caption',
            'sort_order' => 'Urutan',
        ];
    }
}
