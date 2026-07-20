<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEducationRequest extends FormRequest
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
            'level'       => ['required', 'string', 'max:100'],
            'school_name' => ['required', 'string', 'max:255'],
            'major'       => ['nullable', 'string', 'max:255'],
            'start_year'  => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'end_year'    => ['nullable', 'digits:4', 'integer', 'min:1900', 'max:' . (date('Y') + 10), 'gte:start_year'],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'level'       => 'Jenjang Pendidikan',
            'school_name' => 'Nama Sekolah / Universitas',
            'major'       => 'Jurusan',
            'start_year'  => 'Tahun Masuk',
            'end_year'    => 'Tahun Lulus',
            'description' => 'Deskripsi',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'end_year.gte' => 'Tahun Lulus tidak boleh lebih kecil dari Tahun Masuk.',
        ];
    }
}
