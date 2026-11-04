<?php

use App\Models\User;
use Modules\Authors\Models\Author;
use Modules\Books\Models\Book;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('menolak form penulis yang kosong', function () {
    $this->post(route('authors.store'), [])
        ->assertSessionHasErrors([
            'name' => 'Nama penulis wajib diisi.',
            'email' => 'Email wajib diisi.',
        ]);
});

it('menolak email tidak valid dan bio terlalu panjang', function () {
    $this->post(route('authors.store'), [
        'name' => 'A',
        'email' => 'bukan-email',
        'bio' => str_repeat('x', 1001),
    ])->assertSessionHasErrors([
        'email' => 'Format email tidak valid.',
        'bio' => 'Bio maksimal 1000 karakter.',
    ]);
});

it('menolak email penulis yang sudah digunakan', function () {
    Author::create(['name' => 'Satu', 'email' => 'sama@example.com']);

    $this->post(route('authors.store'), ['name' => 'Dua', 'email' => 'sama@example.com'])
        ->assertSessionHasErrors(['email' => 'Email sudah digunakan penulis lain.']);
});

it('menyimpan penulis yang valid', function () {
    $this->post(route('authors.store'), ['name' => 'Baru', 'email' => 'baru@example.com'])
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('authors.index'));

    expect(Author::where('email', 'baru@example.com')->exists())->toBeTrue();
});

it('menolak penghapusan penulis yang masih punya buku', function () {
    $author = Author::create(['name' => 'Punya Buku', 'email' => 'buku@example.com']);
    Book::create([
        'author_id' => $author->id,
        'title' => 'Buku A',
        'isbn' => '9780132350884',
        'published_year' => 2008,
        'price' => 100000,
        'stock' => 1,
    ]);

    $this->delete(route('authors.destroy', $author))
        ->assertSessionHas('error', "Penulis 'Punya Buku' tidak dapat dihapus karena masih memiliki 1 buku.");

    expect(Author::find($author->id))->not->toBeNull();
});

it('menghapus penulis yang tidak punya buku', function () {
    $author = Author::create(['name' => 'Kosong', 'email' => 'kosong@example.com']);

    $this->delete(route('authors.destroy', $author))->assertSessionHas('success');

    expect(Author::find($author->id))->toBeNull();
});
