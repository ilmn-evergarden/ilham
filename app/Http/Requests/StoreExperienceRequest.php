<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
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
            'company'         => ['required', 'string', 'max:255'],
            'position'        => ['required', 'string', 'max:255'],
            'employment_type' => ['required', 'string', 'max:100'],
            'start_date'      => ['required', 'date'],
            // end_date is required only when not currently working
            'end_date'        => [
                'nullable',
                'date',
                'after_or_equal:start_date',
                'required_if:is_current,0,false,',
            ],
            'is_current'      => ['nullable', 'boolean'],
            'description'     => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'company'         => 'Nama Perusahaan / Instansi',
            'position'        => 'Posisi',
            'employment_type' => 'Jenis Pengalaman',
            'start_date'      => 'Tanggal Mulai',
            'end_date'        => 'Tanggal Selesai',
            'is_current'      => 'Status Masih Bekerja',
            'description'     => 'Deskripsi',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'end_date.required_if'       => 'Tanggal Selesai wajib diisi jika tidak sedang bekerja.',
            'end_date.after_or_equal'    => 'Tanggal Selesai tidak boleh sebelum Tanggal Mulai.',
        ];
    }
}
