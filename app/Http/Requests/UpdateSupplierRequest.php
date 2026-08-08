<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $supplierId = $this->route('supplier');
        if (is_object($supplierId)) {
            $supplierId = $supplierId->id;
        }

        return [
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('suppliers', 'code')->ignore($supplierId),
            ],
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama supplier wajib diisi.',
            'code.required' => 'Kode supplier wajib diisi.',
            'code.unique' => 'Kode supplier sudah digunakan oleh supplier lain.',
            'email.email' => 'Format email supplier tidak valid.',
        ];
    }
}
