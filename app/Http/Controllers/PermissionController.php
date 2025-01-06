<?php

namespace App\Http\Controllers;

use App\Models\Permissions\Permission;
use Illuminate\View\View;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:browse-permissions')->only('index');
        $this->middleware('permission:read-permissions')->only('show');
    }

    public function index(): View
    {
        return view('permissions.index');
    }

    public function show($id): View
    {
        $model = Permission::query()->findOrFail($id);

        return view('permissions.show', [
            'model' => $model,
        ]);
    }
}
