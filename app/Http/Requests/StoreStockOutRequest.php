<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockOutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'nullable|numeric|min:0',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Pilih produk yang akan dikeluarkan.',
            'quantity.required' => 'Jumlah barang keluar wajib diisi.',
            'quantity.min' => 'Jumlah barang keluar minimal 1.',
            'transaction_date.required' => 'Tanggal transaksi wajib diisi.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled('product_id') && $this->filled('quantity')) {
                $product = \App\Models\Product::find($this->product_id);
                if ($product && (int) $this->quantity > $product->current_stock) {
                    $validator->errors()->add('quantity', "Jumlah barang keluar ({$this->quantity} {$product->unit}) melebihi stok yang tersedia (Maksimal: {$product->current_stock} {$product->unit}).");
                }
            }
        });
    }
}
