<div class="mb-4">
    <label for="name" class="block text-sm font-medium text-gray-700">Nama Penulis</label>
    <input type="text" name="name" id="name" value="{{ old('name', $author?->name) }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    <x-input-error :messages="$errors->get('name')" class="mt-1" />
</div>

<div class="mb-4">
    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
    <input type="text" name="email" id="email" value="{{ old('email', $author?->email) }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    <x-input-error :messages="$errors->get('email')" class="mt-1" />
</div>

<div class="mb-4">
    <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
    <textarea name="bio" id="bio" rows="4"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('bio', $author?->bio) }}</textarea>
    <x-input-error :messages="$errors->get('bio')" class="mt-1" />
</div>

<button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Simpan
</button>
<a href="{{ route('authors.index') }}" class="ml-2 text-gray-600 hover:text-gray-800">Batal</a>
