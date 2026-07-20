<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkillRequest extends FormRequest
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
            'name'     => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'level'    => ['required', 'integer', 'min:0', 'max:100'],
            'icon'     => ['nullable', 'mimes:jpg,jpeg,png,webp,svg', 'max:1024'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name'     => 'Nama Skill',
            'category' => 'Kategori',
            'level'    => 'Level',
            'icon'     => 'Icon',
        ];
    }
}
