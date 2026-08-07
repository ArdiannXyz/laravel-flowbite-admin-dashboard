<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttributeController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->get('search');
        $attributes = Attribute::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('values', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('pages.inventory.attributes.index', compact('attributes', 'search'));
    }

    public function create(): View
    {
        return view('pages.inventory.attributes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'values' => 'nullable|string',
        ]);

        Attribute::create($validated);

        return redirect()->route('attributes.index')->with('success', 'Atribut produk berhasil ditambahkan.');
    }

    public function edit(int $id): View
    {
        $attribute = Attribute::findOrFail($id);
        return view('pages.inventory.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $attribute = Attribute::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'values' => 'nullable|string',
        ]);

        $attribute->update($validated);

        return redirect()->route('attributes.index')->with('success', 'Atribut produk berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();

        return redirect()->route('attributes.index')->with('success', 'Atribut produk berhasil dihapus.');
    }
}
