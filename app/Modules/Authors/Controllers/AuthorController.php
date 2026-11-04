<?php

namespace Modules\Authors\Controllers;

use App\Http\Controllers\Controller;
use Modules\Authors\Exceptions\AuthorHasBooksException;
use Modules\Authors\Models\Author;
use Modules\Authors\Requests\StoreAuthorRequest;
use Modules\Authors\Requests\UpdateAuthorRequest;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')->orderBy('name')->paginate(10);

        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(StoreAuthorRequest $request)
    {
        Author::create($request->validated());

        return redirect()
            ->route('authors.index')
            ->with('success', 'Penulis berhasil ditambahkan.');
    }

    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $author->update($request->validated());

        return redirect()
            ->route('authors.index')
            ->with('success', 'Penulis berhasil diperbarui.');
    }

    public function destroy(Author $author)
    {
        $bookCount = $author->books()->count();

        if ($bookCount > 0) {
            throw new AuthorHasBooksException($author->name, $bookCount);
        }

        $author->delete();

        return redirect()
            ->route('authors.index')
            ->with('success', 'Penulis berhasil dihapus.');
    }
}
