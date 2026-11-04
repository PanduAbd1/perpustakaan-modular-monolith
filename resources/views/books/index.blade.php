<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Buku') }}
            </h2>
            <a href="{{ route('books.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Tambah Buku
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">No</th>
                                <th class="py-3 px-6 text-left">Judul</th>
                                <th class="py-3 px-6 text-left">ISBN</th>
                                <th class="py-3 px-6 text-left">Penulis</th>
                                <th class="py-3 px-6 text-center">Tahun</th>
                                <th class="py-3 px-6 text-right">Harga</th>
                                <th class="py-3 px-6 text-center">Stok</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse ($books as $index => $book)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 text-left">{{ $books->firstItem() + $index }}</td>
                                <td class="py-3 px-6 text-left">{{ $book->title }}</td>
                                <td class="py-3 px-6 text-left">{{ $book->isbn }}</td>
                                <td class="py-3 px-6 text-left">{{ $book->author->name }}</td>
                                <td class="py-3 px-6 text-center">{{ $book->published_year }}</td>
                                <td class="py-3 px-6 text-right">Rp {{ number_format($book->price, 2, ',', '.') }}</td>
                                <td class="py-3 px-6 text-center">{{ $book->stock }}</td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex items-center justify-center space-x-3">
                                        <form action="{{ route('books.borrow', $book) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-800 font-semibold">Pinjam</button>
                                        </form>
                                        <a href="{{ route('books.edit', $book) }}" class="text-blue-500 hover:text-blue-700 font-semibold">Edit</a>
                                        <form action="{{ route('books.destroy', $book) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="py-4 px-6 text-center text-gray-500">
                                    Belum ada data buku.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $books->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
