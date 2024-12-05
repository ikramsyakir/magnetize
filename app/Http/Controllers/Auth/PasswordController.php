<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profiles\UpdatePasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PasswordController extends Controller
{
    public function edit(): View
    {
        return view('profile.update-password');
    }

    public function update(UpdatePasswordRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        flash()->success(__('messages.password_successfully_updated'));

        return response()->json(['status' => true, 'redirect' => route('profile.update-password', absolute: false)]);
    }
}
