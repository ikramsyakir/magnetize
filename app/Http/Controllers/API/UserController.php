<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserChangedEmail;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;

    public function update(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'avatar' => 'nullable|mimes:jpg,jpeg,png'
        ]);

        $user->name = $validated['name'];
        $user->username = $validated['username'];

        if ($user->email != $validated['email']) {
            $user->email_verified_at = null;
            $user->email = $validated['email'];
            $user->notify(new UserChangedEmail());
        } else {
            $user->email = $validated['email'];
        }

        $path = $request->hasFile('avatar') ? $request->file('avatar')->store('uploads/avatars') : null;
        $user->avatar = $path ?? $user->avatar;
        $user->update();

        return $this->success([
            'user' => $user
        ], 'User updated!');
    }
}
