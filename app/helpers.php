<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

if ( ! function_exists('set_active'))
{
    function set_active(string $routeName): ?string
    {
        return Str::startsWith(Route::currentRouteName(), $routeName) ? 'active' : null;
    }
}
