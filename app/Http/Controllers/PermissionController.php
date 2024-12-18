<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePermission;
use App\Http\Requests\UpdatePermission;
use App\Models\Permissions\Permission;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:browse-permissions')->only('index');
        $this->middleware('permission:read-permissions')->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(CreatePermission $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $permission = new Permission();
        $permission->name = $validated['name'];
        $permission->display_name = $validated['display_name'];
        $permission->description = $validated['description'];
        $permission->save();

        alert()->success('Success', 'Successfully added');
        return redirect()->route('permissions.index');
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(UpdatePermission $request, $id)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $permission = Permission::findOrFail($id);
        $permission->name = $validated['name'];
        $permission->display_name = $validated['display_name'];
        $permission->description = $validated['description'];
        $permission->update();

        alert()->success('Success', 'Successfully updated!');
        return redirect()->route('permissions.index');
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
            $permission = Permission::findOrFail($id);
            $permission->delete();

            $response = [
                'success' => true,
                'error' => false,
                'data' => $permission,
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
