<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUser;
use App\Http\Requests\UpdateUser;
use App\Models\Role;
use App\Models\User;
use App\Notifications\UserChangedEmail;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Avatar;
use Throwable;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:read-user')->only('index', 'changeStatus');
        $this->middleware('permission:create-user')->only('create', 'store');
        $this->middleware('permission:update-user')->only('edit', 'update');
        $this->middleware('permission:user-profile')->only('show');
        $this->middleware('permission:delete-user')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $users = User::filter($request->all())->sortable()->paginate($request->get('limit') ?? config('app.per_page'));
        $roles = Role::pluck('display_name', 'name');
        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUser $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateUser $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $user = new User();
        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);

        if (isset($validated['roles']) && $validated['roles']) {
            $user->assignRole($validated['roles']);
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('uploads/avatars');
        } else {
            $path = 'uploads/avatars/' . uniqid() . '-' . now()->timestamp . '.png';
            $avatar = new Avatar(config('laravolt.avatar'));
            $avatar->create($user->name)->save($path, 100);
        }

        $user->avatar = $path;

        $user->save();

        if ($validated['status'] == 1) {
            $user->markEmailAsVerified();
        } else {
            $user->sendEmailVerificationNotification();
        }

        alert()->success('Success', 'User created!');
        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->cannot('read-user') && ($user->id != auth()->user()->id)) {
            abort(403);
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
     * @param UpdateUser $request
     * @param $id
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
            $user->notify(new UserChangedEmail());
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
     * @param $id
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
        } catch (Exception | Throwable $e) {
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
     * @param $id
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
        } catch (Exception | Throwable $e) {
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
