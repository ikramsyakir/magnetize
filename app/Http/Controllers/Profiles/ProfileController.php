<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Users\User;
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

    public function update(ProfileUpdateRequest $request)
    {
        $validated = $request->validated();

        $user = $request->user();

        $user->name = $validated['name'];

        if ($user->isDirty('email')) {
            $user->email = $validated['email'];
            $user->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            Storage::delete(User::STORAGE_AVATAR_PATH.$user->avatar);
            $avatar = $request->file('avatar');
            $fileName = $avatar->hashName();
            $avatar->store(User::STORAGE_AVATAR_PATH);
            $user->avatar = $fileName;
            $user->avatar_type = $validated['avatar_type'];
        } else {
            if ($user->avatar_type == User::AVATAR_TYPE_INITIAL) {
                Storage::delete(User::STORAGE_AVATAR_PATH.$user->avatar);
                $fileName = Str::random(30).'.png';
                Avatar::create($user->name)->save(storage_path(User::STORAGE_AVATAR_PATH.$fileName), 100);
                $user->avatar = $fileName;
            }
        }

        flash()->success(__('messages.profile_successfully_updated'));

        $user->save();

        return response()->json(['status' => true, 'redirect' => route('profile.edit', absolute: false)]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
