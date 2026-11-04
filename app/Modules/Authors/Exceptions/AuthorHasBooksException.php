<?php

namespace Modules\Authors\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthorHasBooksException extends Exception
{
    public function __construct(protected string $authorName, protected int $bookCount)
    {
        parent::__construct(
            "Penulis '{$authorName}' tidak dapat dihapus karena masih memiliki {$bookCount} buku."
        );
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function getBookCount(): int
    {
        return $this->bookCount;
    }

    public function report(): void
    {
        Log::error($this->getMessage(), [
            'exception' => static::class,
            'author' => $this->authorName,
            'book_count' => $this->bookCount,
        ]);
    }

    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $this->getMessage(),
                'error' => 'author_has_books',
                'details' => [
                    'author' => $this->authorName,
                    'book_count' => $this->bookCount,
                ],
            ], 422);
        }

        return back()->with('error', $this->getMessage());
    }
}
