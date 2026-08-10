<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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
}