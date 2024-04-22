<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Get users with roles.
         */

        $roles = Role::all()->sortBy('name');
        $role_names = $roles->pluck('name')->toArray();
        $users = User::role($role_names);

        /**
         * Display view.
         */

        return view('admin.roles.index', [
            'roles' => $roles,
            'total' => $users->count(),
            'users' => $users->paginate(20),
        ]);
    }

    /**
     * Add a role to a user.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::find($validated['user']);
        $user->assignRole($validated['role']);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required|exists:users,id',
            'roles' => 'array',
        ]);

        $user = User::find($validated['user']);
        $user->syncRoles($validated['roles'] ?? []);

        return redirect()->back();
    }
}
