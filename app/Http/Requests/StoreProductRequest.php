<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'min_stock' => 'required|integer|min:0',
            'current_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'buy_price.required' => 'Harga beli wajib diisi.',
            'sell_price.required' => 'Harga jual wajib diisi.',
            'min_stock.required' => 'Stok minimum wajib diisi.',
            'current_stock.required' => 'Stok awal wajib diisi.',
            'unit.required' => 'Satuan produk wajib diisi.',
            'sku.unique' => 'SKU produk sudah digunakan.',
        ];
    }
}
