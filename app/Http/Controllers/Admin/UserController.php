<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $term = '';
        /**
         * Define sorting.
         */

        switch ($request->orderBy) {
            case 'name':
                $orderBy = 'name';
                break;
            case 'email':
                $orderBy = 'email';
                break;
            case 'id':
                $orderBy = 'id';
                break;
            case 'created_at':
                $orderBy = 'created_at';
                break;
            default:
                $orderBy = 'id';
                break;
        }


        switch ($request->orderDirection) {
            case 'asc':
                $orderDirection = 'asc';
                break;
            case 'desc':
                $orderDirection = 'desc';
                break;
            default:
                $orderDirection = 'asc';
                break;
        }

        /**
         * Get users.
         */

        if($request->term) {
            $term = $request->term;
            $users = User::where('name', 'like', '%' . $term . '%')
                ->paginate(20)
                ->appends([
                'orderBy' => $orderBy,
                'orderDirection' => $orderDirection,
            ]);
        } else {
            $users = User::orderBy($orderBy, $orderDirection)
                ->paginate(20)
                ->appends([
                    'orderBy' => $orderBy,
                    'orderDirection' => $orderDirection,
                ]);
        }

        $users_registered_last_week = User::where(
            'created_at',
            '>',
            Carbon::now()->subWeek()->toDateString()
        )->count();
        /**
         * Display view.
         */

        // return view('admin.users.index', [
        //     'orderBy' => $orderBy,
        //     'users' => $users,
        //     'users_registered_last_week' => $users_registered_last_week,
        //     'term' => $term
        // ]);
        return view('admin.users.index', [
            'orderBy' => $orderBy,
            'users' => $users,
            'users_registered_last_week' => $users_registered_last_week,
            'term' => $term
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', [
            'user' => $user,
        ]);
    }

    public function updatePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => ['required','min:4'],
        ]);
        $user = User::findOrFail($user->id);
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->back()->with('success', 'La contraseña ha sido actualizada exitosamente.');
    }
}
