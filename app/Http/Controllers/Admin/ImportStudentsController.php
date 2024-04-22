<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Facades\Excel;

class ImportStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.import-students.index', [

        ]);
    }

    public function import(Request $request)
    {
        $rawData = Excel::toArray(new \stdClass(), $request->file('file'));
        $data_to_import = $rawData[0];

        $students_added = 0;
        for($i=1; $i<=count($data_to_import); $i++){
            if(isset($data_to_import[$i])){
                if($data_to_import[$i][1]!=''){
                    $user = User::create([
                        "name" => $data_to_import[$i][1],
                        "email" => $data_to_import[$i][3],
                        "password" => Hash::make($data_to_import[$i][2]),
                        "utm_source" => Cookie::get('utm_source'),
                        "utm_medium" => Cookie::get('utm_medium'),
                        "utm_campaign" => Cookie::get('utm_campaign'),
                        "utm_term" => Cookie::get('utm_term'),
                        "utm_content" => Cookie::get('utm_content'),
                        "phone" => $data_to_import[$i][6],
                        "study_center" => $data_to_import[$i][7],
                        "study_id" => $data_to_import[$i][2]
                    ]);
                    $user->slug = rand(1000, 9999) . $user->id;
                    $user->save();
                    Subscription::create([
                        'user_id' => $user->id,
                        'plan_id' => Plan::where('slug', 'afiliados')->firstOrFail()->id,
                        'starts_at' => Carbon::now(),
                        'ends_at' => Carbon::now()->addMonths(6),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $students_added +=1;
                }
            }
        }
        return view('admin.import-students.index', [
            'students_added' => $students_added,
        ]);

    }

}
