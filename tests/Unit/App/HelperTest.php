<?php

use Illuminate\Support\Facades\Route;

test('returns active when the route name starts with the given string', function () {
    Route::shouldReceive('currentRouteName')->andReturn('dashboard');

    expect(set_active('dashboard'))->toBe('active');
});

test('returns null when the route name does not start with the given string', function () {
    Route::shouldReceive('currentRouteName')->andReturn('dashboard');

    expect(set_active('profile.edit'))->toBeNull();
});
