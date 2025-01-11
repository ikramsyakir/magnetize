<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class PostFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function title($value)
    {
        return $this->where(function ($q) use ($value) {
            return $q->where('title', 'LIKE', "%$value%");
        });
    }

    public function status($value)
    {
        return $this->where(function ($q) use ($value) {
            return $q->where('status', $value);
        });
    }

    public function featured($value)
    {
        return $this->where(function ($q) use ($value) {
            return $q->where('featured', $value);
        });
    }
}
