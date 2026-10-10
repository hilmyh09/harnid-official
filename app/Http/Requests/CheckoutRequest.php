<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_phone' => ['required', 'string', 'regex:/^[0-9+][0-9\s\-]{7,20}$/'],
            'customer_email' => ['nullable', 'email', 'max:150'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:80'],
            'province' => ['required', 'string', 'max:80'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'customer_name' => 'nama', 'customer_phone' => 'nomor WhatsApp', 'customer_email' => 'email',
            'address' => 'alamat', 'city' => 'kota', 'province' => 'provinsi', 'postal_code' => 'kode pos', 'notes' => 'catatan',
        ];
    }

    public function messages(): array
    {
        return ['customer_phone.regex' => 'Format nomor WhatsApp tidak valid.'];
    }
}
