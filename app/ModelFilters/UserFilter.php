<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{
    public function name(string $value)    // @phpstan-ignore-line
    {
        return $this->whereLike('name', $value);
    }
}
