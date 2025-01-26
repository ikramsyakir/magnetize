<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUser;
use App\Http\Requests\Users\CreateUserRequest;
use App\Models\Roles\Role;
use App\Models\Users\User;
use App\Notifications\UserChangedEmail;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravolt\Avatar\Facade as Avatar;
use Throwable;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:browse-users')->only('index');
        $this->middleware('permission:read-users')->only('show');
        $this->middleware('permission:edit-users')->only('edit', 'update');
        $this->middleware('permission:add-users')->only('create', 'store');
        $this->middleware('permission:delete-users')->only('destroy');
    }

    public function index(): View
    {
        return view('users.index');
    }

    public function create(): View
    {
        $roles = Role::all();

        return view('users.create', [
            'roles' => $roles,
        ]);
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $model = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (! empty($validated['roles'])) {
            $model->assignRole($validated['roles']);
        }

        $fileName = Str::random(30).'.png';

        if ($request->hasFile('avatar')) {
            $request->file('avatar')->storeAs(User::STORAGE_AVATAR_PATH, $fileName);
            $model->avatar_type = User::AVATAR_TYPE_UPLOADED;
        } else {
            Avatar::create($model->name)->save(storage_path(User::STORAGE_AVATAR_PATH.$fileName), 100);
            $model->avatar_type = User::AVATAR_TYPE_INITIAL;
        }

        $model->avatar = $fileName;

        $model->save();

        if ($validated['verified'] == User::VERIFIED) {
            $model->markEmailAsVerified();
        }

        if ($validated['verified'] == User::UNVERIFIED) {
            $model->sendEmailVerificationNotification();
        }

        flash()->success(__('messages.user_successfully_created'));

        return response()->json(['status' => true, 'redirect' => route('users.index')]);
    }

    public function show($id): View
    {
        $model = User::query()->findOrFail($id);

        return view('users.show', [
            'model' => $model,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|RedirectResponse|View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        if (auth()->user()->cannot('read-user') && ($user->id != auth()->user()->id)) {
            abort(403);
        }

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     */
    public function update(UpdateUser $request, $id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->cannot('read-user') && ($user->id != auth()->user()->id)) {
            abort(403);
        }

        // Retrieve the validated input data...
        $validated = $request->validated();

        $user->name = $validated['name'];
        $user->username = $validated['username'];

        if ($user->email != $validated['email']) {
            $user->email_verified_at = null;
            $user->email = $validated['email'];
            $user->notify(new UserChangedEmail);
        } else {
            $user->email = $validated['email'];
        }

        if ($request->hasFile('avatar')) {
            Storage::delete($user->avatar);
            $path = $request->file('avatar')->store('uploads/avatars');
            $user->avatar = $path;
        }

        if (isset($validated['roles']) && $validated['roles']) {
            $user->syncRoles($validated['roles']);
        }

        $user->update();

        alert()->success('Success', 'User updated!');

        return redirect()->route('users.show', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            Storage::delete($user->avatar);

            $response = [
                'success' => true,
                'error' => false,
                'data' => $user,
                'message' => '',
            ];
        } catch (Exception|Throwable $e) {
            $response = [
                'success' => false,
                'error' => true,
                'data' => null,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($response);
    }

    /**
     * Change status verify
     *
     * @return JsonResponse
     */
    public function changeStatus($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->hasVerifiedEmail()) {
                $user->email_verified_at = null;
                $user->sendEmailVerificationNotification();
            } else {
                $user->markEmailAsVerified();
            }

            $user->update();

            $response = [
                'success' => true,
                'error' => false,
                'data' => $user,
                'message' => '',
            ];
        } catch (Exception|Throwable $e) {
            $response = [
                'success' => false,
                'error' => true,
                'data' => null,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($response);
    }
}
