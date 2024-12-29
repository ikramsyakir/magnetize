<?php

namespace App\Models\Permissions;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    use HasFactory;

    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => __('permissions.'.$value),
        );
    }

    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => __('permissions.'.$value),
        );
    }
}
