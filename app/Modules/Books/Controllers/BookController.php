<?php

namespace Modules\Books\Controllers;

use App\Http\Controllers\Controller;
use Modules\Authors\Models\Author;
use Modules\Books\Exceptions\BookNotAvailableException;
use Modules\Books\Models\Book;
use Modules\Books\Requests\StoreBookRequest;
use Modules\Books\Requests\UpdateBookRequest;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('author')->latest()->paginate(10);

        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::orderBy('name')->get(['id', 'name']);

        return view('books.create', compact('authors'));
    }

    public function store(StoreBookRequest $request)
    {
        Book::create($request->validated());

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        $authors = Author::orderBy('name')->get(['id', 'name']);

        return view('books.edit', compact('book', 'authors'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    public function borrow(Book $book)
    {
        // Pengurangan atomik: hanya berhasil jika stok masih > 0 (validasi stok sebelum peminjaman).
        $affected = Book::whereKey($book->getKey())
            ->where('stock', '>', 0)
            ->decrement('stock');

        if ($affected === 0) {
            throw new BookNotAvailableException($book->title);
        }

        return redirect()
            ->route('books.index')
            ->with('success', "Buku '{$book->title}' berhasil dipinjam.");
    }
}
