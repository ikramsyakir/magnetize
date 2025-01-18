<?php

use App\Models\Users\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'avatar_type' => User::AVATAR_TYPE_INITIAL,
        ]);

    $response->assertSessionHasNoErrors();

    expect($response->json())->toBeArray()
        ->and($user->refresh())
        ->name->toBe('Test User')
        ->email->toBe('test@example.com')->toContain('@')
        ->email_verified_at->toBeNull();
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => $user->email,
            'avatar_type' => User::AVATAR_TYPE_INITIAL,
        ]);

    $response->assertSessionHasNoErrors();

    expect($response->json())->toBeArray()
        ->and($user->refresh())
        ->email_verified_at->not->toBeNull();
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response->assertSessionHasNoErrors();
    $this->assertGuest();

    expect($response->json())->toBeArray()
        ->and($user->refresh()->first())->toBeNull();
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response->assertSessionHasErrors('password');

    expect($user->fresh())->not->toBeNull();
});
