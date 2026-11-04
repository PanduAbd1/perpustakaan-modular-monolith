<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Authors\Models\Author;
use Modules\Books\Models\Book;

class LibrarySeeder extends Seeder
{
    public function run(): void
    {
        $martin = Author::create([
            'name' => 'Robert C. Martin',
            'email' => 'martin@example.com',
            'bio' => 'Penulis buku rekayasa perangkat lunak.',
        ]);

        $bloch = Author::create([
            'name' => 'Joshua Bloch',
            'email' => 'bloch@example.com',
            'bio' => 'Penulis buku pemrograman Java.',
        ]);

        // Penulis tanpa buku, untuk menguji penghapusan yang berhasil.
        Author::create([
            'name' => 'Penulis Tanpa Buku',
            'email' => 'kosong@example.com',
        ]);

        Book::create([
            'author_id' => $martin->id,
            'title' => 'Clean Code',
            'isbn' => '9780132350884',
            'published_year' => 2008,
            'price' => 350000,
            'stock' => 5,
        ]);

        // Stok 0, untuk menguji BookNotAvailableException.
        Book::create([
            'author_id' => $bloch->id,
            'title' => 'Effective Java',
            'isbn' => '9780134685991',
            'published_year' => 2018,
            'price' => 420000,
            'stock' => 0,
        ]);
    }
}
