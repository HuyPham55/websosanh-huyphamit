<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class FaqFilter extends ModelFilter
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
        $languages = array_keys(config('lang'));
        foreach ($languages as $langKey) {
            $this->orWhere("title->{$langKey}", 'LIKE', "%$keyword%");
        }
        return $this;
    }

    public function status($status)
    {
        return $this->where('status', $status);
    }
}
