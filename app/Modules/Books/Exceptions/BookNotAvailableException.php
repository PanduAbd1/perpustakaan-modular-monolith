<?php

namespace Modules\Books\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookNotAvailableException extends Exception
{
    public function __construct(protected string $bookTitle)
    {
        parent::__construct("Buku '{$bookTitle}' tidak tersedia karena stok habis.");
    }

    public function getBookTitle(): string
    {
        return $this->bookTitle;
    }

    public function report(): void
    {
        Log::error($this->getMessage(), [
            'exception' => static::class,
            'book' => $this->bookTitle,
        ]);
    }

    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $this->getMessage(),
                'error' => 'book_not_available',
                'details' => ['book' => $this->bookTitle],
            ], 422);
        }

        return back()->with('error', $this->getMessage());
    }
}
