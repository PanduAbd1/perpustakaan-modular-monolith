<?php

namespace Modules\Authors\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class UpdateAuthorRequest extends StoreAuthorRequest
{
    protected function emailUniqueRule(): Unique
    {
        return Rule::unique('authors', 'email')->ignore($this->route('author'));
    }
}
