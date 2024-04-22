<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityType;
use App\Models\User;
use App\Models\UserActivityLog;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Login page
     *
     * @return void
     */
    public function show()
    {
        return view('auth.login-students');
    }

    /**
     * Handle account login request
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('study_id', 'password');
        //echo $credentials['study_id'];
       // dd(User::all());
        User::where('id', 21)->update(['password' => Hash::make('12345678'),'phone'=>'123456789']);
       // dd($request->all(),Hash::make($request->password),Hash::make('12345678'));
        if (Auth::attempt($credentials)){
            $user = User::where('study_id', $credentials['study_id'])->first();
            // dd($user);
            UserActivityLog::create([
                'user_id' => $user->id,
                'activity_type_id' => ActivityType::where('name', 'USER_LOGGED_IN')->first()->id,
            ]);
            return redirect()->intended();
        }

        return redirect()->route('login-students');
    }

}
