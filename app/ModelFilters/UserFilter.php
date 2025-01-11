<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function name($value)
    {
        return $this->where(function ($q) use ($value) {
            return $q->where('name', 'LIKE', "%$value%");
        });
    }

    public function email($value)
    {
        return $this->where(function ($q) use ($value) {
            return $q->where('email', 'LIKE', "%$value%");
        });
    }

    public function username($value)
    {
        return $this->where(function ($q) use ($value) {
            return $q->where('username', 'LIKE', "%$value%");
        });
    }

    public function status($value)
    {
        return $this->where(function ($q) use ($value) {
            if ($value == 1) {
                return $q->whereNotNull('email_verified_at');
            } elseif ($value == 2) {
                return $q->whereNull('email_verified_at');
            }
        });
    }

    public function roles($value)
    {
        $this->related('roles', function ($query) use ($value) {
            return $query->where('name', $value);
        });
    }
}
