<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ContactFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function keyword($keyword)
    {
        return $this->where('name', 'LIKE', "%$keyword")
            ->orWhere('email', 'LIKE', "%$keyword")
            ->orWhere('subject', 'LIKE', "%$keyword");
    }
}
