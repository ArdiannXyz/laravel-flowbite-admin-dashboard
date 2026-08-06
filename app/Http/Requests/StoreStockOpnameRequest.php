<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockOpnameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'physical_stock' => 'required|integer|min:0',
            'opname_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Pilih produk untuk stock opname.',
            'physical_stock.required' => 'Jumlah stok fisik hasil pemeriksaan wajib diisi.',
            'physical_stock.min' => 'Jumlah stok fisik tidak boleh kurang dari 0.',
            'opname_date.required' => 'Tanggal opname wajib diisi.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled('product_id') && $this->filled('physical_stock')) {
                $product = \App\Models\Product::find($this->product_id);
                if ($product && (int) $this->physical_stock > $product->current_stock) {
                    $validator->errors()->add('physical_stock', "Jumlah stok fisik ({$this->physical_stock} {$product->unit}) tidak boleh melebihi stok yang tercatat di sistem (Maksimal: {$product->current_stock} {$product->unit}).");
                }
            }
        });
    }
}
