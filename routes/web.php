<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Profiles\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Themes\ThemeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    // Change theme
    Route::post('update-theme', ThemeController::class)->name('update-theme');

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Information
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Update Password
    Route::get('/profile/update-password', [PasswordController::class, 'edit'])->name('profile.update-password');

    // Delete Account
    Route::get('/profile/delete-account', [ProfileController::class, 'deleteAccount'])->name('profile.delete-account');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Roles
    Route::resource('roles', RoleController::class);

    // Permission
    Route::resource('permissions', PermissionController::class)->only(['index', 'show']);

    // User
    Route::put('users/change-status/{id}', [UserController::class, 'changeStatus'])->name('users.change-status');
    Route::resource('users', UserController::class);

    // Post
    Route::resource('posts', PostController::class);
});
