<?php

use App\Models\User;
use Modules\Authors\Models\Author;
use Modules\Books\Models\Book;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
    $this->author = Author::create(['name' => 'Penulis Uji', 'email' => 'uji@example.com']);
});

function validBookData(int $authorId, array $override = []): array
{
    return array_merge([
        'title' => 'Clean Code',
        'isbn' => '978-0-13-235088-4',
        'published_year' => 2008,
        'price' => 350000,
        'stock' => 5,
        'author_id' => $authorId,
    ], $override);
}

it('menolak form buku yang kosong', function () {
    $this->post(route('books.store'), [])
        ->assertSessionHasErrors([
            'title' => 'Judul buku wajib diisi.',
            'isbn' => 'ISBN wajib diisi.',
            'published_year' => 'Tahun terbit wajib diisi.',
            'price' => 'Harga buku wajib diisi.',
            'stock' => 'Stok wajib diisi.',
            'author_id' => 'Penulis wajib dipilih.',
        ]);
});

it('menolak ISBN dengan format tidak valid', function () {
    $this->post(route('books.store'), validBookData($this->author->id, ['isbn' => '123']))
        ->assertSessionHasErrors(['isbn' => 'Format ISBN tidak valid. Gunakan ISBN-10 atau ISBN-13 yang benar.']);
});

it('menolak ISBN yang sudah terdaftar', function () {
    $this->post(route('books.store'), validBookData($this->author->id));
    $this->post(route('books.store'), validBookData($this->author->id, ['title' => 'Duplikat']))
        ->assertSessionHasErrors(['isbn' => 'ISBN sudah terdaftar.']);
});

it('menolak tahun terbit di luar rentang', function () {
    $this->post(route('books.store'), validBookData($this->author->id, ['published_year' => 1899]))
        ->assertSessionHasErrors(['published_year' => 'Tahun terbit minimal 1900.']);

    $this->post(route('books.store'), validBookData($this->author->id, ['published_year' => now()->year + 1, 'isbn' => '9780134685991']))
        ->assertSessionHasErrors('published_year');
});

it('menolak harga dan stok negatif', function () {
    $this->post(route('books.store'), validBookData($this->author->id, ['price' => -1, 'stock' => -1]))
        ->assertSessionHasErrors([
            'price' => 'Harga tidak boleh negatif.',
            'stock' => 'Stok tidak boleh negatif.',
        ]);
});

it('menolak author yang tidak ada', function () {
    $this->post(route('books.store'), validBookData(9999))
        ->assertSessionHasErrors(['author_id' => 'Penulis yang dipilih tidak ditemukan.']);
});

it('menyimpan buku yang valid', function () {
    $this->post(route('books.store'), validBookData($this->author->id))
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('books.index'))
        ->assertSessionHas('success');

    expect(Book::where('isbn', '9780132350884')->exists())->toBeTrue();
});

it('mengizinkan update buku dengan ISBN miliknya sendiri', function () {
    $book = Book::create(validBookData($this->author->id, ['isbn' => '9780132350884']));

    $this->put(route('books.update', $book), validBookData($this->author->id, ['title' => 'Judul Baru']))
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('books.index'));

    expect($book->fresh()->title)->toBe('Judul Baru');
});

it('melempar BookNotAvailableException saat meminjam buku stok 0', function () {
    $book = Book::create(validBookData($this->author->id, ['isbn' => '9780132350884', 'stock' => 0]));

    $this->post(route('books.borrow', $book))
        ->assertSessionHas('error', "Buku 'Clean Code' tidak tersedia karena stok habis.");

    expect($book->fresh()->stock)->toBe(0);
});

it('mengurangi stok saat peminjaman berhasil', function () {
    $book = Book::create(validBookData($this->author->id, ['isbn' => '9780132350884', 'stock' => 2]));

    $this->post(route('books.borrow', $book))->assertSessionHas('success');

    expect($book->fresh()->stock)->toBe(1);
});
