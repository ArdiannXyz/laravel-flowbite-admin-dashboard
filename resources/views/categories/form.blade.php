@csrf

<div class="mb-5">
    <label class="block mb-2 text-sm font-medium text-gray-900">
        Nama Kategori
    </label>

    <input
        type="text"
        name="name"
        value="{{ old('name', $category->name ?? '') }}"
        class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"
        required>

    @error('name')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mb-5">
    <label class="block mb-2 text-sm font-medium text-gray-900">
        Deskripsi
    </label>

    <textarea
        name="description"
        rows="4"
        class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">{{ old('description', $category->description ?? '') }}</textarea>

    @error('description')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<button
    type="submit"
    class="text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5">
    Simpan
</button>