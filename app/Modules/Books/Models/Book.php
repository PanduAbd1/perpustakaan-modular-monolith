<?php

namespace Modules\Books\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Authors\Models\Author;

class Book extends Model
{
    protected $fillable = [
        'author_id',
        'title',
        'isbn',
        'published_year',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'published_year' => 'integer',
        'stock' => 'integer',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
