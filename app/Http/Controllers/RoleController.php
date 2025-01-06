<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roles\CreateRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Models\Permissions\Permission;
use App\Models\Roles\Role;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
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

        return view('roles.create', [
            'permissions' => $permissions,
        ]);
    }

    public function store(CreateRoleRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $model = Role::create($validated);

        if (!empty($request->permissions)) {
            $model->syncPermissions($validated['permissions']);
        }

        flash()->success(__('messages.role_successfully_created'));

        return response()->json([
            'status' => true, 'message' => 'Role successfully created', 'redirect' => route('roles.index')
        ]);
    }

    public function show($id): View
    {
        $model = Role::query()->findOrFail($id);

        return view('roles.show', [
            'model' => $model,
        ]);
    }

    public function edit($id): View
    {
        $model = Role::with('permissions')->findOrFail($id);

        $rolePermissions = $model->permissions->pluck('name')->toArray();

        $permissions = Permission::all();

        return view('roles.edit', [
            'model' => $model,
            'rolePermissions' => $rolePermissions,
            'permissions' => $permissions
        ]);
    }

    public function update(UpdateRoleRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();

        $model = Role::query()->find($id);

        if (!$model) {
            return response()->json(['status' => false, 'message' => __('messages.role_not_found')],
                Response::HTTP_NOT_FOUND);
        }

        $model->update($validated);

        if (!empty($validated['permissions'])) {
            $model->syncPermissions($validated['permissions']);
        }

        flash()->success(__('messages.role_successfully_updated'));

        return response()->json([
            'status' => true, 'message' => 'Role successfully updated', 'redirect' => route('roles.index')
        ]);
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
