<div class="mb-4">
    <label for="title" class="block text-sm font-medium text-gray-700">Judul Buku</label>
    <input type="text" name="title" id="title" value="{{ old('title', $book?->title) }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    <x-input-error :messages="$errors->get('title')" class="mt-1" />
</div>

<div class="mb-4">
    <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
    <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book?->isbn) }}"
        placeholder="Contoh: 978-0-13-235088-4"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    <x-input-error :messages="$errors->get('isbn')" class="mt-1" />
</div>

<div class="mb-4">
    <label for="published_year" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
    <input type="number" name="published_year" id="published_year" value="{{ old('published_year', $book?->published_year) }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    <x-input-error :messages="$errors->get('published_year')" class="mt-1" />
</div>

<div class="mb-4">
    <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $book?->price) }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    <x-input-error :messages="$errors->get('price')" class="mt-1" />
</div>

<div class="mb-4">
    <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
    <input type="number" name="stock" id="stock" value="{{ old('stock', $book?->stock) }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    <x-input-error :messages="$errors->get('stock')" class="mt-1" />
</div>

<div class="mb-4">
    <label for="author_id" class="block text-sm font-medium text-gray-700">Penulis</label>
    <select name="author_id" id="author_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        <option value="">-- Pilih Penulis --</option>
        @foreach ($authors as $author)
            <option value="{{ $author->id }}" @selected(old('author_id', $book?->author_id) == $author->id)>
                {{ $author->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('author_id')" class="mt-1" />
</div>

<button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Simpan
</button>
<a href="{{ route('books.index') }}" class="ml-2 text-gray-600 hover:text-gray-800">Batal</a>
