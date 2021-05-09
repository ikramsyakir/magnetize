<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRole;
use App\Http\Requests\UpdateRole;
use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Throwable;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:create-role')->only('create', 'store');
        $this->middleware('permission:read-role')->only('index');
        $this->middleware('permission:update-role')->only('edit', 'update');
        $this->middleware('permission:delete-role')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::filter($request->all())->sortable()->paginate($request->get('limit') ?? config('app.per_page'));

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(CreateRole $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $role = new Role();
        $role->name = $validated['name'];
        $role->display_name = $validated['display_name'];
        $role->description = $validated['description'];
        $role->save();

        if (isset($request->permissions) && $request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        alert()->success('Success', 'Successfully added');
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
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
