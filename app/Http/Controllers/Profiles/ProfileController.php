<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profiles\UpdateProfileRequest;
use App\Models\Users\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravolt\Avatar\Facade as Avatar;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = $request->user();

        $user->name = $validated['name'];

        if ($user->isDirty('email')) {
            $user->email = $validated['email'];
            $user->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            $avatarPath = User::PUBLIC_AVATAR_PATH.$user->avatar;

            // Avatar exists
            if (Storage::disk('public')->exists($avatarPath)) {
                Storage::disk('public')->delete($avatarPath);
            }

            $avatar = $request->file('avatar');
            $fileName = $avatar->hashName();
            $avatar->store(User::PUBLIC_AVATAR_PATH, 'public');
            $user->avatar = $fileName;
            $user->avatar_type = $validated['avatar_type'];
        } else {
            if ($validated['avatar_type'] == User::AVATAR_TYPE_INITIAL) {
                $avatarPath = User::PUBLIC_AVATAR_PATH.$user->avatar;

                // Avatar exists
                if (Storage::disk('public')->exists($avatarPath)) {
                    Storage::disk('public')->delete($avatarPath);
                }

                $fileName = Str::random(30).'.png';
                Avatar::create($user->name)->save(storage_path(User::STORAGE_AVATAR_PATH.$fileName), 100);
                $user->avatar = $fileName;
                $user->avatar_type = $validated['avatar_type'];
            }
        }

        flash()->success(__('messages.profile_successfully_updated'));

        $user->update();

        return response()->json(['status' => true, 'redirect' => route('profile.edit', absolute: false)]);
    }

    public function deleteAccount(): View
    {
        return view('profile.delete-account');
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        flash()->success(__('messages.account_successfully_deleted'));

        return response()->json(['status' => true, 'redirect' => route('login', absolute: false)]);
    }
}
