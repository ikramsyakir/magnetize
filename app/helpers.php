<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

if (! function_exists('set_active')) {
    function set_active(string $routeName): ?string
    {
        return Str::startsWith(Route::currentRouteName(), $routeName) ? 'active' : null;
    }
}

if (! function_exists('to_options')) {
    function to_options(array $array): array
    {
        return array_merge([
            '' => __('messages.all'),
        ], $array);
    }
}
