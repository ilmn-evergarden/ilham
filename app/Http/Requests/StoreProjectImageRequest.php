<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectImageRequest extends FormRequest
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
            // Allow both single upload and multiple via 'images[]'
            'images'          => ['required', 'array', 'min:1'],
            'images.*'        => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'captions'        => ['nullable', 'array'],
            'captions.*'      => ['nullable', 'string', 'max:255'],
            'sort_orders'     => ['nullable', 'array'],
            'sort_orders.*'   => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'images'   => 'Gambar',
            'images.*' => 'Gambar',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'images.required' => 'Pilih minimal satu gambar untuk diunggah.',
            'images.*.image'  => 'File harus berupa gambar.',
            'images.*.mimes'  => 'Format gambar harus JPG, JPEG, PNG, atau WebP.',
            'images.*.max'    => 'Ukuran gambar maksimal 2 MB.',
        ];
    }
}
