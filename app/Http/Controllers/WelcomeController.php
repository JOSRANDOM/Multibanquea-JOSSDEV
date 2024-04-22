<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    /**
     * Show the welcome page.
     * For logged in users, redirect to the "home" page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('welcome.' . config('variant.name'));
    }
}
