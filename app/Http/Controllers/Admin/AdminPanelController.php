<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Exam;
use Spatie\Permission\Models\Role;

class AdminPanelController extends Controller
{
    /**
     * Display the admin home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all()->sortBy('name');
        $role_names = $roles->pluck('name')->toArray();
        $users_roles = User::role($role_names)->count();

        $users_new = User::whereDate('created_at',now())->count();
        $users_active = User::select('id')->join('subscriptions','subscriptions.user_id','=','users.id')->where('ends_at', '>=', now())->where('starts_at', '<=', now())->count() - $users_roles;
        $users_inactive = User::select('id')->count() - $users_active -$users_roles;
        $users_admin = $users_roles;
        $exams = Exam::whereDate('created_at',now())->count();



        $data = [];
        $data['menu'] = 'dashboard';
        $data['smenu'] = '';
        $data['users_new'] = $users_new;
        $data['users_active'] = $users_active;
        $data['users_inactive'] = $users_inactive;
        $data['users_admin'] = $users_admin;
        $data['exams'] = $exams;
        return view('admin.dashboard',$data);
        // return view('admin.index');
    }
}
