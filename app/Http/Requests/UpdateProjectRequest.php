<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
            'title'       => ['required', 'string', 'max:255'],
            'slug'        => ['required', 'string', 'max:255', Rule::unique('projects', 'slug')->ignore($this->route('project'))],
            'description' => ['required', 'string'],
            'thumbnail'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'github_url'  => ['nullable', 'url', 'max:255'],
            'demo_url'    => ['nullable', 'url', 'max:255'],
            'status'      => ['required', Rule::in(Project::statuses())],
            'start_date'  => ['nullable', 'date'],
            'end_date'    => ['nullable', 'date', 'after_or_equal:start_date'],
            'featured'    => ['nullable', 'boolean'],
            'technologies'   => ['required', 'array', 'min:1'],
            'technologies.*' => ['integer', 'exists:technologies,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title'        => 'Judul Project',
            'slug'         => 'Slug',
            'description'  => 'Deskripsi',
            'thumbnail'    => 'Thumbnail',
            'github_url'   => 'GitHub URL',
            'demo_url'     => 'Demo URL',
            'status'       => 'Status',
            'start_date'   => 'Tanggal Mulai',
            'end_date'     => 'Tanggal Selesai',
            'featured'     => 'Featured',
            'technologies' => 'Technology',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'technologies.required'   => 'Pilih minimal satu technology.',
            'technologies.min'        => 'Pilih minimal satu technology.',
            'end_date.after_or_equal' => 'Tanggal Selesai tidak boleh sebelum Tanggal Mulai.',
        ];
    }
}
