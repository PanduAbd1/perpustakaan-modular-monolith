<?php

namespace Modules\Books\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class UpdateBookRequest extends StoreBookRequest
{
    protected function isbnUniqueRule(): Unique
    {
        return Rule::unique('books', 'isbn')->ignore($this->route('book'));
    }
}
