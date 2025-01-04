<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roles\CreateRoleRequest;
use App\Http\Requests\UpdateRole;
use App\Models\Permissions\Permission;
use App\Models\Roles\Role;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:browse-roles')->only('index');
        $this->middleware('permission:read-roles')->only('show');
        $this->middleware('permission:edit-roles')->only('edit', 'update');
        $this->middleware('permission:add-roles')->only('create', 'store');
        $this->middleware('permission:delete-roles')->only('destroy');
    }

    public function index(): View
    {
        return view('roles.index');
    }

    public function create(): View
    {
        $permissions = Permission::all();

        return view('roles.create', compact('permissions'));
    }

    public function store(CreateRoleRequest $request): JsonResponse
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $model = Role::create($validated);

        if (!empty($request->permissions)) {
            $model->syncPermissions($validated['permissions']);
        }

        flash()->success(__('messages.role_successfully_created'));

        return response()->json([
            'status' => true, 'message' => 'Role created successfully', 'redirect' => route('roles.index')
        ]);
    }

    public function show($id): View
    {
        $model = Role::query()->findOrFail($id);

        return view('roles.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $permissions = Permission::all();

        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return RedirectResponse|\Illuminate\Http\Response
     */
    public function update(UpdateRole $request, $id)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $role = Role::findOrFail($id);
        $role->name = $validated['name'];
        $role->display_name = $validated['display_name'];
        $role->description = $validated['description'];
        $role->update();

        if (isset($request->permissions) && $request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        alert()->success('Success', 'Successfully updated!');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            $response = [
                'success' => true,
                'error' => false,
                'data' => $role,
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
