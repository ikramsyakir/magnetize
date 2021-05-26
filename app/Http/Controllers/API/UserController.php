<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserChangedEmail;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use ApiResponse;

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

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

        if ($request->hasFile('avatar')) {
            Storage::delete($user->avatar);
            $path = $request->file('avatar')->store('uploads/avatars');
            $user->avatar = $path;
        }

        $user->update();

        return $this->success([
            'user' => $user
        ], 'User updated!');
    }
}
