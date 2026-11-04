<?php

namespace Modules\Authors\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Books\Models\Book;

class Author extends Model
{
    protected $fillable = ['name', 'email', 'bio'];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
