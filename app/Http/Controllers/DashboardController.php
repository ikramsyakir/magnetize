<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Role;
use App\Models\Users\User;

class DashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['total_user'] = User::all()->count();
        $data['total_role'] = Role::all()->count();
        $data['total_post'] = Post::all()->count();

        return view('dashboard', $data);
    }
}
