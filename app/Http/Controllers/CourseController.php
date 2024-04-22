<?php

namespace App\Http\Controllers;

use App\Models\CourseVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseSubject;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
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
        $platform = strtolower(config('variant.name'));
        $id_platform = 0;
        if($platform=='enae'){
            $id_platform = 1;
        } else if($platform=='enao'){
            $id_platform = 2;
        }
        else if($platform=='enam'){
            $id_platform = 3;
        }

        $courses_header = DB::table('course_subject')->select('course_name','id')
            ->where('course_subject.id_platform', $id_platform)
            ->get();

        $new_list = array();
        for($i=0 ; $i< count($courses_header)  ;$i++) {
            $courses = DB::table('course_video')
                ->where('id_course', $courses_header[$i]->id)
                ->get()->toArray();
            array_push($new_list, $courses);
        }
        return view('courses.index', [
            'user' => Auth::user(),
            'courses_header' => $courses_header,
            'courses' => $new_list,
        ]);
    }

    public function showCourse(String $url)
    {
        return view('courses.show', [
            'user' => Auth::user(),
            'url' => $url,
        ]);
    }
}
