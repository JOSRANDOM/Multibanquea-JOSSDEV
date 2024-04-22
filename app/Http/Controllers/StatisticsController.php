<?php

namespace App\Http\Controllers;

use App\Models\QuestionCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Exam;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request as Request2;
// use DB;

class StatisticsController extends Controller
{
    /**
     * Display the main statistics page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::findOrFail(Auth::id());

        $chart_data = $user->exams->whereNotNull("completed_at")->sortBy("completed_at")->map(function ($exam) {
            return [
                'x' => $exam->completed_at,
                'y' => $exam->score,
            ];
        })->values();

        return view('statistics.index', [
            'chart_data' => $chart_data,
        ]);
    }

    public function index_new()
    {
        $user = User::findOrFail(Auth::id());

        // $chart_data = $user->exams->whereNotNull("completed_at")->sortBy("completed_at")->map(function ($exam) {
        //     return [
        //         'x' => $exam->completed_at,
        //         'y' => $exam->score,
        //     ];
        // })->values();

        return view('statistics.index-new', [
            // 'chart_data' => $chart_data,
        ]);
    }
    public function exams_load(Request2 $request){

        $input = $request->all();

        $start = $input['start'];
        $length = $input['length'];
        // $status = $input['status'];
        $search = $input['search']['value'];
        $columna = $input['order'][0]['column'];
        $order = $input['order'][0]['dir'];
        $init_at = $input['init_at'] . ' 00:00:00';
        $end_at = $input['end_at'] . ' 23:59:59';


        $order_by = 'created_at';
        // switch ($columna) {
        //     case 1:
        //         $order_by = 'clinic_history';
        //         break;
        //     case 2:
        //         $order_by = 'report_at';
        //         break;
        //     case 3:
        //         $order_by = 'patient_name';
        //         break;
        //     case 4:
        //         $order_by = 'doctor_name';
        //         break;
        //     case 5:
        //         $order_by = 'cia_name';
        //         break;
        //     case 6:
        //         $order_by = 'doctor_name';
        //         break;
        // }
        $page = ($start == 0) ? 1 : (($start / $length) + 1);

        $q = Exam::with(['question_category'])->where('user_id',Auth::id());

        if (strlen($search) > 0) {
            $q->where(function ($q) use ($search) {
                $q->where("type", "LIKE", "%" . $search . "%");
                $q->where("total_questions", "LIKE", "%" . $search . "%");
                $q->where("score", "LIKE", "%" . $search . "%");
            });
        }
        $q->whereBetween('created_at', [$init_at, $end_at]);
        $q->orderBy($order_by, $order);
        $e = $q->paginate($length, ['*'], $page, $page);

        $data = $e->toArray();

        $result = array();
        $result['data'] = $data['data'];
        $result['draw'] = $_POST['draw'];
        $result['recordsTotal'] = $e->total();
        $result['recordsFiltered'] = $e->total();
        return response(json_encode($result), 200);

    }

    public function exams_load_chart(Request2 $request){
        $result = [];
        $input = $request->all();

        $init_at = $input['init_at'] . ' 00:00:00';
        $end_at = $input['end_at'] . ' 23:59:59';
        // $dates =  $this->getDaysChart( $input['init_at'],$input['end_at'] );


        $exams = Exam::select(DB::raw("(DATE_FORMAT(created_at, '%Y-%m-%d')) as my_date"),'type',DB::raw("round(avg(score),2) as prom"),DB::raw("SUM(1) as total"))
                        ->where('user_id',Auth::id())
                        ->whereNotNull("completed_at")
                        ->whereBetween('created_at', [$init_at, $end_at])
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"),'type')
                        ->get();

        $dates = [];

        foreach ($exams as $key => $exam) {
            if(!isset($dates[$exam->my_date])){
                $dates[$exam->my_date]= [
                    'balanced'=>0,
                    'standar'=>0,
                    'category'=>0,
                    'simulacrum'=>0,
                    'special'=>0,
                ];
            }
            switch ($exam->type) {
                case 'BALANCED':
                    $dates[$exam->my_date]['balanced'] = round($exam->prom);
                    break;
                case 'STANDARD':
                    $dates[$exam->my_date]['standar'] = round($exam->prom);
                    break;
                case 'CATEGORY':
                    $dates[$exam->my_date]['category'] = round($exam->prom);
                    break;
                case 'SIMULACRUM':
                    $dates[$exam->my_date]['simulacrum'] = round($exam->prom);
                    break;
                case 'SPECIAL':
                    $dates[$exam->my_date]['special'] = round($exam->prom);
                    break;
            }

        }


        return response(json_encode($dates), 200);
    }

    public function detail_load(Request2 $request){
        $result = [];
        $input = $request->all();
        $exam = Exam::where('public_id',$input['exam'])->first();
        $type = $input['type'];
        //categoria o subcategoria;
        $labels = [];
        $datasets= [
            'label' => 'Puntuacion',
            'data' => [],
            'backgroundColor'=> 'rgba(2, 85, 81, 0.25)',
            'borderColor'=> 'rgb(2, 85, 81)',
            'pointBackgroundColor'=> 'rgb(2, 85, 81)',
            'pointBorderColor'=> '#fff',
            'pointHoverBackgroundColor'=> '#fff',
            'pointHoverBorderColor'=> 'rgb(2, 85, 81)',
            'fill' => true
        ];

        if($type == '0'){
            $data = DB::table('exam_question')
            ->select(
                 DB::raw('ROUND(SUM(exam_question.correct) / COUNT(exam_question.correct) * 100) AS score'),
                'question_subcategories.question_category_id',
                'question_categories.name'
            )
            ->join('questions', 'exam_question.question_id', 'questions.id')
            ->join('question_subcategories', 'questions.question_subcategory_id', 'question_subcategories.id')
            ->join('question_categories', 'question_subcategories.question_category_id', 'question_categories.id')
            ->where('exam_question.exam_id', '=', $exam->id)

            ->groupBy('question_subcategories.question_category_id')
            // ->orderByDesc('question_subcategories.question_category_id')
            ->orderBy('score','desc')
            ->get();


            // $labels =QuestionCategory::orderBy('name','asc')->pluck('name');



            foreach ($data as $key => $value) {
                $datasets['data'][] = $value->score;
                $labels[] =  $value->name;
            }
        }else{
            $data = DB::table('exam_question')
                        ->select(
                            DB::raw('ROUND(SUM(exam_question.correct) / COUNT(exam_question.correct) * 100) AS score'),
                            'questions.question_subcategory_id',
                            'question_subcategories.name',
                            'question_subcategories.question_category_id'

                        )
                        ->join('questions', 'exam_question.question_id', 'questions.id')
                        ->join('question_subcategories', 'questions.question_subcategory_id', 'question_subcategories.id')
                        ->where('exam_question.exam_id', '=', $exam->id)
                        ->where('question_subcategories.question_category_id', $type)
                        ->groupBy('questions.question_subcategory_id')
                        ->orderByDesc('score')
                        // ->orderBy('question_subcategories.name')
                        ->get();
                foreach ($data as $key => $value) {
                    $datasets['data'][] = $value->score;
                    $labels[] =  $value->name;
                }

        }
        $result['labels'] = $labels;
        $result['datasets'] = [$datasets];
        return response(json_encode($result), 200);
    }
    private function randomColor(){
        $str = "#";
        for($i = 0 ; $i < 6 ; $i++){
        $randNum = rand(0, 15);
        switch ($randNum) {
        case 10: $randNum = "A";
        break;
        case 11: $randNum = "B";
        break;
        case 12: $randNum = "C";
        break;
        case 13: $randNum = "D";
        break;
        case 14: $randNum = "E";
        break;
        case 15: $randNum = "F";
        break;
        }
        $str .= $randNum;
        }
        return $str;
       }

    private function getDaysChart($init_at,$end_at){
        $days_total = Carbon::create($init_at)->diffInDays(Carbon::create($end_at)) ;
        $data = [];
        for ($i=0; $i <= $days_total; $i++) {
            $date_name = Carbon::create($init_at)->addDays($i)->format('Y-m-d');
            $data[$date_name] = [
                'balanced'=>0,
                'standar'=>0,
                'category'=>0,
                'simulacrum'=>0,
                'special'=>0,
            ];
        }

        //

        return $data;
    }

    /**
     * Display the statistics page for a given category.
     *
     * @return \Illuminate\Http\Response
     */
    public function showQuestionCategory(QuestionCategory $question_category)
    {
        /**
         * Get user category questions from DB.
         */

        $chart_data_from_db = DB::table('exam_question')
            ->join('exams', 'exam_question.exam_id', 'exams.id')
            ->join('questions', 'exam_question.question_id', 'questions.id')
            ->join('question_subcategories', 'questions.question_subcategory_id', 'question_subcategories.id')
            ->join('question_categories', 'question_subcategories.question_category_id', 'question_categories.id')
            ->where('exams.user_id', Auth::id())
            ->whereNotNull('exams.completed_at')
            ->where('question_categories.id', $question_category->id)
            ->select('exams.completed_at', 'exam_question.correct')
            ->orderBy('exams.completed_at')
            ->get();

        /**
         * Group questions by week of year.
         */

        $chart_data_by_week = [];

        $chart_data_from_db->map(function ($question) use (&$chart_data_by_week) {
            $completion_week = Carbon::parse($question->completed_at)->startOfWeek()->toString();

            if (!array_key_exists($completion_week, $chart_data_by_week)) {
                $chart_data_by_week[$completion_week] = [
                    'correct' => $question->correct,
                    'total' => 1,
                ];
            } else {
                $chart_data_by_week[$completion_week] = [
                    'correct' => $chart_data_by_week[$completion_week]['correct'] + $question->correct,
                    'total' => $chart_data_by_week[$completion_week]['total'] + 1,
                ];
            }
        })->values();

        /**
         * Prepare chart data.
         */

        $chart_data = [];

        foreach ($chart_data_by_week as $key => $value) {
            $score = (int) round($value['correct'] / $value['total'] * 100);

            array_push($chart_data, [
                'x' => Carbon::parse($key),
                'y' => $score,
            ]);
        }

        /**
         * Display view.
         */

        return view('statistics.show-question-category', [
            'chart_data' => collect($chart_data),
            'question_category' => $question_category,
        ]);
    }

    public function show(Exam $exam){
        $exam_belongs_to_user = Auth::id() == $exam->user->id;

        if (!$exam_belongs_to_user) {
            abort(401);
        }
        /**
         * Check if exam is already completed.
         */
        if(!session()->has('exam_expiration_time')) {
            $expiration_date = $exam->expiration_at;
            if(!isTimeExpired($expiration_date)){
                session()->put('exam_expiration_time', $exam->expiration_at);
            }
        }
        if ($exam->isCompleted()) {

            $scores_by_subcategory = DB::table('exam_question')
                ->select(
                    DB::raw('ROUND(SUM(exam_question.correct) / COUNT(exam_question.correct) * 100) AS score'),
                    'questions.question_subcategory_id',
                    'question_subcategories.name',
                    'question_subcategories.question_category_id',
                    DB::raw('SUM(exam_question.correct) as correct'),
                    DB::raw('COUNT(1) as total')
                )
                ->join('questions', 'exam_question.question_id', 'questions.id')
                ->join('question_subcategories', 'questions.question_subcategory_id', 'question_subcategories.id')
                ->where('exam_question.exam_id', '=', $exam->id)
                ->groupBy('questions.question_subcategory_id')
                ->orderByDesc('score')
                ->orderBy('question_subcategories.name')
                ->get();
// dd($scores_by_subcategory);
            return view('statistics.show', [
                'exam' => $exam,
                'scores_by_subcategory' => $scores_by_subcategory,
                'user' => Auth::user(),
            ]);
        }
    }
}
