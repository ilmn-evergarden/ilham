<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTechnologyRequest extends FormRequest
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
            // Ignore the current record's own name when checking uniqueness
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('technologies', 'name')->ignore($this->route('technology')),
            ],
            'icon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:1024'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nama Technology',
            'icon' => 'Icon',
        ];
    }
}
