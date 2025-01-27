<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Roles\Role;
use App\Models\Users\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravolt\Avatar\Facade as Avatar;
use Symfony\Component\HttpFoundation\Response;

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

        $fileName = Str::random(30);
        $avatarPath = User::STORAGE_AVATAR_PATH;

        if ($request->hasFile('avatar')) {
            $fileExtension = $request->file('avatar')->extension();
            $fileName .= '.'.$fileExtension;
            $request->file('avatar')->storeAs($avatarPath, $fileName);
            $model->avatar_type = User::AVATAR_TYPE_UPLOADED;
        } else {
            $fileName .= '.png';
            Avatar::create($model->name)->save(storage_path($avatarPath.$fileName), 100);
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

    public function edit($id): View
    {
        $model = User::query()->findOrFail($id);

        $currentRoles = $model->roles->pluck('name')->toArray();

        $roles = Role::all();

        return view('users.edit', [
            'model' => $model,
            'currentRoles' => $currentRoles,
            'roles' => $roles,
        ]);
    }

    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();

        $model = User::query()->find($id);

        if (! $model) {
            return response()->json(['status' => false, 'message' => __('messages.user_not_found')],
                Response::HTTP_NOT_FOUND);
        }

        $model->name = $validated['name'];
        $model->email = $validated['email'];

        if (! empty($validated['roles'])) {
            $model->assignRole($validated['roles']);
        }

        $fileName = Str::random(30);
        $avatarPath = User::STORAGE_AVATAR_PATH;
        $currentAvatar = $avatarPath.$model->avatar;

        // Delete the existing avatar file if it exists
        if (Storage::exists($currentAvatar)) {
            Storage::delete($currentAvatar);
        }

        if ($request->hasFile('avatar')) {
            // Store the uploaded avatar
            $fileExtension = $request->file('avatar')->extension();
            $fileName .= '.'.$fileExtension;
            $request->file('avatar')->storeAs($avatarPath, $fileName);
            $model->avatar_type = User::AVATAR_TYPE_UPLOADED;
        } else {
            // Generate and save an avatar using the user's name
            $fileName .= '.png';
            Avatar::create($model->name)->save(storage_path($avatarPath.$fileName), 100);
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

        flash()->success(__('messages.user_successfully_updated'));

        return response()->json(['status' => true, 'redirect' => route('users.index')]);
    }
}
