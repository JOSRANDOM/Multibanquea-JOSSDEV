<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\DemoMail;
use App\Models\Exam;
use App\Models\User;
use App\Notifications\ExamCreated;
use Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'user' => Auth::user(),
        ]);
    }
    public function email(){

        $user = User::findOrFail(6291);
        $exam = Exam::where('id',28614)->first();
        $user->notify(new ExamCreated($exam));


        // echo 'enviaremos email por aca ';
        // $mailData = [
        //     'title' => 'Mail from ItSolutionStuff.com',
        //     'body' => 'This is for testing email using smtp.'
        // ];

        // Mail::to('cristof.vergara@gmail.com')->send(new DemoMail($mailData));

        dd("Email is sent successfully.");
    }
}
