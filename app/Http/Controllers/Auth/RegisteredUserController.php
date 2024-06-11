<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravolt\Avatar\Avatar;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole('user');

        File::ensureDirectoryExists(storage_path(User::STORAGE_AVATAR_PATH));

        // Create default avatar
        $fileName = Str::random(30).'.png';
        $avatar = new Avatar(config('laravolt.avatar'));
        $avatar->create($user->name)->save(storage_path(User::STORAGE_AVATAR_PATH.$fileName), 100);
        $user->avatar = $fileName;
        $user->update();

        event(new Registered($user));

        Auth::login($user);

        return response()->json(['status' => true, 'redirect' => route('dashboard', absolute: false)]);
    }
}
