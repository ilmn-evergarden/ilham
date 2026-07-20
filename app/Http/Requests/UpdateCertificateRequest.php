<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCertificateRequest extends FormRequest
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
            'title'           => ['required', 'string', 'max:255'],
            'issuer'          => ['required', 'string', 'max:255'],
            'issue_date'      => ['required', 'date'],
            'expiration_date' => ['nullable', 'date', 'after_or_equal:issue_date'],
            'credential_id'   => ['nullable', 'string', 'max:255'],
            'credential_url'  => ['nullable', 'url', 'max:255'],
            'image'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description'     => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title'           => 'Judul Sertifikat',
            'issuer'          => 'Penerbit',
            'issue_date'      => 'Tanggal Terbit',
            'expiration_date' => 'Tanggal Kedaluwarsa',
            'credential_id'   => 'Credential ID',
            'credential_url'  => 'Credential URL',
            'image'           => 'Gambar Sertifikat',
            'description'     => 'Deskripsi',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'expiration_date.after_or_equal' => 'Tanggal Kedaluwarsa tidak boleh sebelum Tanggal Terbit.',
        ];
    }
}
