<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AcademyController extends Controller
{
    //

    public function index()
    {
        $user = User::findOrFail(Auth::id());
        return view('academy.index', [
            'user' => $user
        ]);
    }
    public function createExamQualifying()
    {



    }
}
