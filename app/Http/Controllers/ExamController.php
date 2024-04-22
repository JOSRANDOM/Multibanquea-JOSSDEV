<?php

namespace App\Http\Controllers;

use App\Models\ActivityType;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Extraordinary;
use App\Models\ExtraordinaryQuestion;
use App\Models\Plan;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\Simulacrum;
use App\Models\SimulacrumQuestion;
use App\Models\User;
use App\Models\UserActivityLog;
use App\Notifications\ExamCreated;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use DateTime;

class ExamController extends Controller
{
    private $errorMessages = [
        'user-has-product-exam-in-progress' => 'Actualmente tienes un examen en progreso. Por favor complétalo antes de crear un nuevo examen.',
    ];

    /**
     * Create an exam public ID.
     *
     * @return string
     */
    private function createExamPublicId()
    {
        $public_id = '';

        do {
            $public_id = Str::random(12);
        } while (Exam::where('public_id', $public_id)->count() > 0);

        return $public_id;
    }

    public function calcule_questions()
    {
        ini_set('memory_limit', -1);
        $exams = Exam::where('total_questions', 0)->get();
        // $exams = Exam::where('total_questions',0)->whereNotNull('completed_at')->get();
        // dd($exams);
        foreach ($exams as $key => $exam) {
            echo 'se trabajo el ' . $exam->public_id;
            if ($exam->completed_at) {
                $exam->total_correct_questions = $exam->correct_questions()->count();
                $exam->total_incorrect_questions = $exam->incorrect_questions()->count();
            }
            $exam->total_questions = $exam->questions()->count();
            $exam->save();
        }
    }

    /**
     * Number of exams available for the user to create.
     *
     * @return boolean
     */
    private function userExamsAvailable()
    {
        $user = Auth::user();

        if ($user->isSubscribed()) {
            return 1;
        }

        $exams_available_weekly = 3;
        $one_week_ago = (Carbon::now()->subDays(7)->toDateString());

        $user_exams_created_last_week = $user->exams->where('created_at', '>=', $one_week_ago)->count();
        $exams_available = $exams_available_weekly - $user_exams_created_last_week;

        return $exams_available;
    }

    /**
     * Whether the logged in user has available exams to create.
     *
     * @return boolean
     */
    private function userHasExamsAvailable()
    {
        if (Auth::user()->isSubscribed()) {
            return true;
        } else if ($this->userExamsAvailable() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::findOrFail(Auth::id());

        return view('exams.index', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = User::findOrFail(Auth::id());

        //VERIFICAR SI HAY SIMULACROS
        $simulacrum_active = Simulacrum::select('*')
            ->leftJoin('simulacrums_classrooms', 'simulacrums_classrooms.simulacrum_id', '=', 'simulacrums.id')
            ->where('simulacrums.active', 1)
            ->where('simulacrums.view_at', '<', now())
            ->where('simulacrums.end_at', '>=', now())
            // ->where('simulacrums_classrooms.active',1)
            ->where(function ($query) use ($user) {
                $query->where('simulacrums.type',  1)
                    ->orWhere(function ($query) use ($user) {
                        $query->where('simulacrums.type', '=', 2)
                            ->where('simulacrums_classrooms.active', '=', 1)
                            ->where('simulacrums_classrooms.intitution', '=', $user->study_center)
                            ->where('simulacrums_classrooms.campus', '=', $user->study_sedes)
                            ->where('simulacrums_classrooms.program', '=', $user->program_t)
                            ->where('simulacrums_classrooms.classroom', '=', $user->aula_t);
                    });
            })
            ->first();
        //VERIFICAR SI HAY EXTRAORDINARIOS
        $extraordinary_active = Extraordinary::select('*')
            ->leftJoin('extraordinary_classrooms', 'extraordinary_classrooms.simulacrum_id', '=', 'extraordinary.id')
            ->where('extraordinary.active', 1)
            ->where('extraordinary.view_at', '<', now())
            ->where('extraordinary.end_at', '>=', now())
            // ->where('extraordinary_classrooms.active',1)
            ->where(function ($query) use ($user) {
                $query->where('extraordinary.type',  1)
                    ->orWhere(function ($query) use ($user) {
                        $query->where('extraordinary.type', '=', 2)
                            ->where('extraordinary_classrooms.active', '=', 1)
                            ->where('extraordinary_classrooms.intitution', '=', $user->study_center)
                            ->where('extraordinary_classrooms.campus', '=', $user->study_sedes)
                            ->where('extraordinary_classrooms.program', '=', $user->program_t)
                            ->where('extraordinary_classrooms.classroom', '=', $user->aula_t);
                    });
            })
            ->first();

        /**
         * Check if the user has an exam in progress.
         */

        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }

        $plan_1 = Plan::find(env('PLAN_1'));

        return view('exams.create', [
            'plan_1' => $plan_1,
            'user' => $user,
            'simulacrum_active' => $simulacrum_active,
            'extraordinary_active' => $extraordinary_active,
        ]);
    }
    public function create_10_03_2024()
    {
        // dd('ja');
        $user = User::findOrFail(Auth::id());
        $simulacrum_switch = env('SIMULACRUM_SWITCH');
        $now = Carbon::now()->format('d-m-Y H:i:s');
        $simulacrum_date = Carbon::createFromFormat('Y-m-d H:i:s', env('SIMULACRUM_DATETIME'))->format('d-m-Y H:i');
        // $simulacrum_date_compare = Carbon::createFromFormat('Y-m-d H:i:s', env('SIMULACRUM_DATETIME'))->format('d-m-Y H:i');
        $simulacrum_available = 0;
        if (env('SIMULACRUM_DATETIME') <= now()) {
            $simulacrum_available = 1;
        }

        /**
         * Check if the user has an exam in progress.
         */

        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }

        $plan_1 = Plan::find(env('PLAN_1'));

        return view('exams.create', [
            'plan_1' => $plan_1,
            'user' => $user,
            'simulacrum_switch' => $simulacrum_switch,
            'simulacrum_available' => $simulacrum_available,
            'simulacrum_date' => $simulacrum_date
        ]);
    }
    /**
     * Show the form for creating a new resource from type "balanced exam".
     *
     * @return \Illuminate\Http\Response
     */
    public function createBalanced()
    {
        $user = User::findOrFail(Auth::id());

        /**
         * Check if the user has an exam in progress.
         */

        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }

        /**
         * Available exam sizes.
         */
        $exam_sizes = DB::table('balanced_exam_categories')
            ->select('type', DB::raw('SUM(size) AS questions'))
            ->groupBy('type')
            ->orderBy('questions')
            ->get()
            ->pluck('questions', 'type');

        /**
         * Display view.
         */

        return view('exams.create-balanced', [
            'exam_sizes' => $exam_sizes,
        ]);
    }

    /**
     * Show the form for creating a new resource from type "balanced exam".
     *
     * @return \Illuminate\Http\Response
     */
    public function createSimulacrum()
    {
        $user = User::findOrFail(Auth::id());

        /**
         * Check if the user has an exam in progress.
         */

        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }

        //VERIFICAR SI HAY SIMULACROS
        $simulacrums = Simulacrum::select('*')
            ->with(['exams'])
            ->leftJoin('simulacrums_classrooms', 'simulacrums_classrooms.simulacrum_id', '=', 'simulacrums.id')
            ->where('simulacrums.active', 1)
            ->where('simulacrums.view_at', '<', now())
            ->where('simulacrums.end_at', '>=', now())
            // ->where('simulacrums_classrooms.active',1)
            ->where(function ($query) use ($user) {
                $query->where('simulacrums.type',  1)
                    ->orWhere(function ($query) use ($user) {
                        $query->where('simulacrums.type', '=', 2)
                            ->where('simulacrums_classrooms.active', '=', 1)
                            ->where('simulacrums_classrooms.intitution', '=', $user->study_center)
                            ->where('simulacrums_classrooms.campus', '=', $user->study_sedes)
                            ->where('simulacrums_classrooms.program', '=', $user->program_t)
                            ->where('simulacrums_classrooms.classroom', '=', $user->aula_t);
                    });
            })
            ->orderBy('init_at', 'ASC')
            ->get();

        /**
         * Display view.
         */

        return view('exams.create-simulacrum', [
            // 'exam_sizes' => $exam_sizes,
            'simulacrums' => $simulacrums,
        ]);

        /**
         * Display view.
         */
        /*return view('exams.create-simulacrum');*/
    }

    /**
     * Show the form for creating a new resource from type "balanced exam".
     *
     * @return \Illuminate\Http\Response
     */
    public function createExtraordinary()
    {
        $user = User::findOrFail(Auth::id());

        /**
         * Check if the user has an exam in progress.
         */

        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }

        //VERIFICAR SI HAY SIMULACROS
        $extraordinary = Extraordinary::select('*')
            ->with(['exams'])
            ->leftJoin('extraordinary_classrooms', 'extraordinary_classrooms.simulacrum_id', '=', 'extraordinary.id')
            ->where('extraordinary.active', 1)
            ->where('extraordinary.view_at', '<', now())
            ->where('extraordinary.end_at', '>=', now())
            // ->where('extraordinary_classrooms.active',1)
            ->where(function ($query) use ($user) {
                $query->where('extraordinary.type',  1)
                    ->orWhere(function ($query) use ($user) {
                        $query->where('extraordinary.type', '=', 2)
                            ->where('extraordinary_classrooms.active', '=', 1)
                            ->where('extraordinary_classrooms.intitution', '=', $user->study_center)
                            ->where('extraordinary_classrooms.campus', '=', $user->study_sedes)
                            ->where('extraordinary_classrooms.program', '=', $user->program_t)
                            ->where('extraordinary_classrooms.classroom', '=', $user->aula_t);
                    });
            })
            ->orderBy('init_at', 'ASC')
            ->get();

        /**
         * Display view.
         */

        return view('exams.create-extraordinary', [
            // 'exam_sizes' => $exam_sizes,
            'exams' => $extraordinary,
        ]);
    }

    /**
     * Show the form for creating a new resource from type "STANDARD".
     *
     * @return \Illuminate\Http\Response
     */
    public function createStandard()
    {
        $user = User::findOrFail(Auth::id());

        /**
         * Check if the user has an exam in progress.
         */

        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }

        /**
         * Calculate the date for the next available exam. Only relevant for
         * free tier users with no more free exams available.
         */

        $user_has_exams_available = $this->userHasExamsAvailable();
        $next_available_exams_date = Carbon::now();

        if (!$user_has_exams_available) {
            $third_to_last_user_exam = Auth::user()->exams->sortByDesc('created_at')->skip(2)->first();
            $next_available_exams_date = $third_to_last_user_exam->created_at->copy()->addDays(7);
        }

        /**
         * Display view.
         */

        $plan_1 = Plan::find(env('PLAN_1'));

        return view('exams.create-standard', [
            'next_available_exams_date' => $next_available_exams_date,
            'plan_1' => $plan_1,
            'user_has_exams_available' => $user_has_exams_available,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource from type "CATEGORY".
     *
     * @return \Illuminate\Http\Response
     */
    public function createCategory()
    {
        $user = User::findOrFail(Auth::id());

        /**
         * Check if the user has an exam in progress.
         */

        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }

        /**
         * Display view.
         */

        return view('exams.create-category', [
            'question_categories' => QuestionCategory::all()->sortBy('name'),
        ]);
    }
    /**
     * Show the form for creating a new resource from type "SPECIAL".
     *

     */
    public function createSpecial()
    {
        $user = User::findOrFail(Auth::id());

        /**
         * Check if the user has an exam in progress.
         */

        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }

        /**
         * Display view.
         */

        return view('exams.create-special', [
            'question_categories' => QuestionCategory::with(['question_subcategories'])->get()->sortBy('name'),
        ]);
    }
    public function storeSpecial(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }
        //CREAR EXAMEN CON TIEMPO

        $cant_questions = 0;
        $question_categories_sizes = $request->questions;

        $question_ids = [];
        foreach ($question_categories_sizes as $question_subcategory_id => $size) {
            if ($size > 0) {
                $cant_questions++;
                $question_ids_from_category = DB::table('questions')
                    ->where('questions.question_subcategory_id', '=', $question_subcategory_id)
                    ->where('questions.active', '=', true)
                    ->where('questions.bank_questions', '=', 1)
                    ->select('questions.id')
                    ->get()
                    ->pluck('id')
                    ->random($size)
                    ->toArray();
                $question_ids = array_merge($question_ids, $question_ids_from_category);
            }
        }

        if ($cant_questions == 0) {
            $messageBag = new MessageBag();
            $messageBag->add('error', 'No estas seleccionando ninguna pregunta.');
            return back()->with('errors', $messageBag);
        }
        $questions = Question::findMany($question_ids)->shuffle();


        $exam = Exam::create([
            'public_id' => $this->createExamPublicId(),
            'sharing_token' => Str::random(12),
            'type' => 'SPECIAL',
            'user_id' => $user->id,
        ]);

        $exam->questions()->saveMany($questions);

        UserActivityLog::create([
            'user_id' => $user->id,
            'activity_type_id' => ActivityType::where('name', 'USER_CREATED_EXAM')->first()->id,
            'object_id' => $exam->id,
        ]);
        if ($request->examTime > 0) {

            $time = $request->examTime;
            $exam->expiration_at = now()->addMinutes($time);
            $exam->save();
            session()->put('exam_expiration_time', $exam->expiration_at);
        }
        /**
         * Send notifications.
         */

        $user->notify(new ExamCreated($exam));

        if ($user->study_id != '') setExpirationTime($exam, getTimeExam($exam->questions()->count()));



        return redirect()->route('exams.show', $exam);
    }

    /**
     * Store a newly created BALANCED exam in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type  Balanced exam type
     * @return \Illuminate\Http\Response
     */
    public function storeBalanced(Request $request, string $type)
    {
        $user = User::findOrFail(Auth::id());

        /**
         * Check if the user has an exam in progress.
         */

        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }

        /**
         * Create and store the new exam.
         */
        $question_categories_sizes = DB::table('balanced_exam_categories')
            ->where('type', '=', $type)
            ->get()
            ->pluck('size', 'question_category_id')
            ->toArray();

        $question_ids = [];

        foreach ($question_categories_sizes as $question_category_id => $size) {
            $question_ids_from_category = DB::table('questions')
                ->join('question_subcategories', 'questions.question_subcategory_id', 'question_subcategories.id')
                ->where('question_subcategories.question_category_id', '=', $question_category_id)
                ->where('questions.active', '=', true)
                ->where('questions.bank_questions', '=', 1)
                ->select('questions.id')
                ->get()
                ->pluck('id')
                ->random($size)
                ->toArray();
            $question_ids = array_merge($question_ids, $question_ids_from_category);
        }

        $questions = Question::findMany($question_ids)->shuffle();

        $exam = Exam::create([
            'public_id' => $this->createExamPublicId(),
            'sharing_token' => Str::random(12),
            'type' => 'BALANCED',
            'user_id' => $user->id,
        ]);

        $exam->questions()->saveMany($questions->shuffle());

        UserActivityLog::create([
            'user_id' => $user->id,
            'activity_type_id' => ActivityType::where('name', 'USER_CREATED_EXAM')->first()->id,
            'object_id' => $exam->id,
        ]);

        /**
         * Send notifications.
         */

        $user->notify(new ExamCreated($exam));

        if ($user->study_id != '') setExpirationTime($exam, getTimeExam($exam->questions()->count()));

        /**
         * Redirect to route.
         */

        return redirect()->route('exams.show', $exam);
    }
    /**
     * Store a newly created casual exam in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeExtraordinary(Request $request, string $slug)
    {
        $user = User::findOrFail(Auth::id());

        /**
         * Check if the user has an exam in progress.
         */

        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }
        //VALIDAR EXAMEN ESTA ACTIVO Y EN RANGO
        $simulacrum = Extraordinary::where('slug', $slug)
            ->where('active', 1)
            ->where('init_at', '<=', now())
            ->where('end_at', '>=', now())
            ->first();



        if (!$simulacrum) {
            $messageBag = new MessageBag();
            $messageBag->add('error', 'No se encontro examen extraordinario');
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }
        //VALIDAR SI EL USUARIO YA TIENE LA CANTIDA DE EXAMENES QUE TIENE EL EXAMEN
        $exam_count = Exam::where('user_id', $user->id)->where('simulacrum', $simulacrum->slug)->count();
        // $exam_exist = Exam::where('user_id', $user->id)->where('simulacrum', $simulacrum->slug)->first();
        if ($exam_count ==  $simulacrum->amount) {
            $messageBag = new MessageBag();
            $messageBag->add('error', 'Ya resolviste el maximo número la practica ' . $simulacrum->name);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }


        $question_ids = [];
        // VALIDAR TIPO DE EXAMEN
        // ALEATORIO 1
        // PRECISAS 2
        if ($simulacrum->question_type == 1) {

            $question_categories_sizes = DB::table('balanced_exam_categories')
                ->where('type', '=', $simulacrum->balance_exam_category_type)
                ->get();

            foreach ($question_categories_sizes as $key => $questions_data) {
                // VALIDAR SI ES CATEGORIA (0) O SUBCATEGORIA != 0
                if ($questions_data->question_subcategory_id == 0) {
                    $question_ids_from_category = DB::table('questions')
                        ->join('question_subcategories', 'questions.question_subcategory_id', 'question_subcategories.id')
                        ->where('question_subcategories.question_category_id', '=', $questions_data->question_category_id)
                        ->where('questions.active', '=', true)
                        ->select('questions.id')
                        ->get()
                        ->pluck('id')
                        ->random($questions_data->size)
                        ->toArray();
                    $question_ids = array_merge($question_ids, $question_ids_from_category);
                } else {
                    $question_ids_from_category = DB::table('questions')
                        ->join('question_subcategories', 'questions.question_subcategory_id', 'question_subcategories.id')
                        ->where('question_subcategories.question_category_id', '=', $questions_data->question_category_id)
                        ->where('questions.question_subcategory_id', $questions_data->question_subcategory_id)
                        ->where('questions.active', '=', true)
                        ->select('questions.id')
                        ->select('questions.id')
                        ->get()
                        ->pluck('id')
                        ->random($questions_data->size)
                        ->toArray();
                    $question_ids = array_merge($question_ids, $question_ids_from_category);
                }
            }
        } else  if ($simulacrum->question_type == 2) {
            $question_ids = ExtraordinaryQuestion::where('simulacrum_id', $simulacrum->id)
                ->where('active', 1)
                ->pluck('question_id')
                ->toArray();
        }

        $questions = Question::findMany($question_ids)->shuffle();


        $exam = Exam::create([
            'public_id' => $this->createExamPublicId(),
            'sharing_token' => Str::random(12),
            'type' => 'EXTRAORDINARY',
            'simulacrum' => $simulacrum->slug,
            'user_id' => $user->id,

        ]);

        $exam->questions()->saveMany($questions);

        UserActivityLog::create([
            'user_id' => $user->id,
            'activity_type_id' => ActivityType::where('name', 'USER_CREATED_EXAM')->first()->id,
            'object_id' => $exam->id,
            'value' => $simulacrum->name
        ]);

        /**
         * Send notifications.
         */

        //ENVIA NOTIFICACION
        // $user->notify(new ExamCreated($exam));
        $dateDiff = Carbon::now()->diffInMinutes($simulacrum->end_at, false);
        // $dateDiff2 = Carbon::now()->diffInMinutes($simulacrum->end_at,true);
        $expiration_at = Carbon::createFromFormat('Y-m-d H:i:s', now())->addMinutes($simulacrum->time);
        if ($dateDiff < $simulacrum->time) {
            $expiration_at =  $simulacrum->end_at;
        }

        $exam->expiration_at = $expiration_at;

        $exam->save();
        session()->put('exam_expiration_time', $exam->expiration_at);


        /**
         * Redirect to route.
         */

        return redirect()->route('exams.show', $exam);
    }
    /**
     * Store a newly created casual exam in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSimulacrum(Request $request, string $slug)
    {
        $user = User::findOrFail(Auth::id());

        /**
         * Check if the user has an exam in progress.
         */

        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }
        //VALIDAR EXAMEN ESTA ACTIVO Y EN RANGO
        $simulacrum = Simulacrum::where('slug', $slug)
            ->where('active', 1)
            ->where('init_at', '<=', now())
            ->where('end_at', '>=', now())
            ->first();



        if (!$simulacrum) {
            $messageBag = new MessageBag();
            $messageBag->add('error', 'No se encontro examen');
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }
        //VALIDAR SI EL USUARIO YA TIENE UN EXAMEN CON EL CODIGO

        $exam_exist = Exam::where('user_id', $user->id)->where('simulacrum', $simulacrum->slug)->first();
        if ($exam_exist) {
            $messageBag = new MessageBag();
            $messageBag->add('error', 'Ya respondiste la practica ' . $simulacrum->name);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }


        $question_ids = [];
        // VALIDAR TIPO DE EXAMEN
        // ALEATORIO 1
        // PRECISAS 2
        if ($simulacrum->question_type == 1) {
            // DEPRECATED ONLY CATEGORIES
            //19 03 2024
            //Kriztof
            // $question_categories_sizes = DB::table('balanced_exam_categories')
            //     ->where('type', '=', $simulacrum->balance_exam_category_type)
            //     ->get()
            //     ->pluck('size', 'question_category_id')
            //     ->toArray();

            //     foreach ($question_categories_sizes as $question_category_id => $size) {
            //         $question_ids_from_category = DB::table('questions')
            //         ->join('question_subcategories', 'questions.question_subcategory_id', 'question_subcategories.id')
            //         ->where('question_subcategories.question_category_id', '=', $question_category_id)
            //         ->where('questions.active', '=', true)
            //         ->select('questions.id')
            //         ->get()
            //         ->pluck('id')
            //         ->random($size)
            //         ->toArray();
            //         $question_ids = array_merge($question_ids, $question_ids_from_category);
            //     }
            // EN DEPRECATED KRIZTOF
            $question_categories_sizes = DB::table('balanced_exam_categories')
                ->where('type', '=', $simulacrum->balance_exam_category_type)
                ->get();

            foreach ($question_categories_sizes as $key => $questions_data) {
                // VALIDAR SI ES CATEGORIA (0) O SUBCATEGORIA != 0
                if ($questions_data->question_subcategory_id == 0) {
                    $question_ids_from_category = DB::table('questions')
                        ->join('question_subcategories', 'questions.question_subcategory_id', 'question_subcategories.id')
                        ->where('question_subcategories.question_category_id', '=', $questions_data->question_category_id)
                        ->where('questions.active', '=', true)
                        ->select('questions.id')
                        ->get()
                        ->pluck('id')
                        ->random($questions_data->size)
                        ->toArray();
                    $question_ids = array_merge($question_ids, $question_ids_from_category);
                } else {
                    $question_ids_from_category = DB::table('questions')
                        ->join('question_subcategories', 'questions.question_subcategory_id', 'question_subcategories.id')
                        ->where('question_subcategories.question_category_id', '=', $questions_data->question_category_id)
                        ->where('questions.question_subcategory_id', $questions_data->question_subcategory_id)
                        ->where('questions.active', '=', true)
                        ->select('questions.id')
                        ->select('questions.id')
                        ->get()
                        ->pluck('id')
                        ->random($questions_data->size)
                        ->toArray();
                    $question_ids = array_merge($question_ids, $question_ids_from_category);
                }
            }
        } else  if ($simulacrum->question_type == 2) {
            $question_ids = SimulacrumQuestion::where('simulacrum_id', $simulacrum->id)
                ->where('active', 1)
                ->pluck('question_id')
                ->toArray();
        }

        $questions = Question::findMany($question_ids)->shuffle();


        $exam = Exam::create([
            'public_id' => $this->createExamPublicId(),
            'sharing_token' => Str::random(12),
            'type' => 'SIMULACRUM',
            'simulacrum' => $simulacrum->slug,
            'user_id' => $user->id,

        ]);

        $exam->questions()->saveMany($questions);

        UserActivityLog::create([
            'user_id' => $user->id,
            'activity_type_id' => ActivityType::where('name', 'USER_CREATED_EXAM')->first()->id,
            'object_id' => $exam->id,
            'value' => $simulacrum->name
        ]);

        /**
         * Send notifications.
         */

        //ENVIA NOTIFICACION
        // $user->notify(new ExamCreated($exam));
        $dateDiff = Carbon::now()->diffInMinutes($simulacrum->end_at, false);
        // $dateDiff2 = Carbon::now()->diffInMinutes($simulacrum->end_at,true);
        $expiration_at = Carbon::createFromFormat('Y-m-d H:i:s', now())->addMinutes($simulacrum->time);
        if ($dateDiff < $simulacrum->time) {
            $expiration_at =  $simulacrum->end_at;
        }

        $exam->expiration_at = $expiration_at;

        $exam->save();
        session()->put('exam_expiration_time', $exam->expiration_at);


        /**
         * Redirect to route.
         */

        return redirect()->route('exams.show', $exam);
    }
    public function storeSimulacrum2024_03_10(Request $request, string $type)
    {
        $user = User::findOrFail(Auth::id());

        /**
         * Check if the user has an exam in progress.
         */

        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }

        $question_categories_sizes = DB::table('balanced_exam_categories')
            ->where('type', '=', $type)
            ->get()
            ->pluck('size', 'question_category_id')
            ->toArray();

        $question_ids = [];

        foreach ($question_categories_sizes as $question_category_id => $size) {
            $question_ids_from_category = DB::table('questions')
                ->join('question_subcategories', 'questions.question_subcategory_id', 'question_subcategories.id')
                ->where('question_subcategories.question_category_id', '=', $question_category_id)
                ->where('questions.active', '=', true)
                ->select('questions.id')
                ->get()
                ->pluck('id')
                ->random($size)
                ->toArray();
            $question_ids = array_merge($question_ids, $question_ids_from_category);
        }

        $questions = Question::findMany($question_ids)->shuffle();


        $exam = Exam::create([
            'public_id' => $this->createExamPublicId(),
            'sharing_token' => Str::random(12),
            'type' => 'SIMULACRUM',
            'user_id' => $user->id,
        ]);

        $exam->questions()->saveMany($questions);

        UserActivityLog::create([
            'user_id' => $user->id,
            'activity_type_id' => ActivityType::where('name', 'USER_CREATED_EXAM')->first()->id,
            'object_id' => $exam->id,
        ]);

        /**
         * Send notifications.
         */

        $user->notify(new ExamCreated($exam));

        //if ($user->study_id!='') setExpirationTime($exam, getTimeExam($exam->questions()->count()));
        //kriztof validate tiem 14-11-2023
        //  if($user->study_id!=''){
        $type_end_exam = ENV('SIMULACRUM_TIME_EXACT', 0);
        $time = getTimeExam($exam->questions()->count());
        $expiration_at = Carbon::now()->addMinutes($time);
        if ($type_end_exam == '1') {
            $init_exam_data = ENV('SIMULACRUM_DATETIME');
            $expiration_at = Carbon::createFromFormat('Y-m-d H:i:s', $init_exam_data)->addMinutes($time);
        }
        $exam->expiration_at = $expiration_at;

        $exam->save();
        session()->put('exam_expiration_time', $exam->expiration_at);
        //  }

        /**
         * Redirect to route.
         */

        return redirect()->route('exams.show', $exam);
    }



    /**
     * Store a newly created casual exam in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeStandard(Request $request, $size)
    {
        $user = User::findOrFail(Auth::id());

        /**
         * Check if the user has an exam in progress.
         */

        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }

        /**
         * Check if user may create an exam.
         */

        $user_can_create_from_free_tier = $this->userHasExamsAvailable() && $size == 10;
        $user_can_create_from_premium_tier = $user->isSubscribed() && ($size == 50 || $size == 100);

        if (!$user_can_create_from_free_tier && !$user_can_create_from_premium_tier) {
            abort(401);
        }

        /**
         * Create and store the new exam.
         */

        $questions = Question::where('active', true)->where('bank_questions', '=', 1)->get()->random($size)->shuffle();

        $exam = Exam::create([
            'public_id' => $this->createExamPublicId(),
            'sharing_token' => Str::random(12),
            'type' => 'STANDARD',
            'user_id' => $user->id,
        ]);

        $exam->questions()->saveMany($questions);

        UserActivityLog::create([
            'user_id' => $user->id,
            'activity_type_id' => ActivityType::where('name', 'USER_CREATED_EXAM')->first()->id,
            'object_id' => $exam->id,
        ]);

        /**
         * Send notifications.
         */

        $user->notify(new ExamCreated($exam));



        if ($user->study_id != '') setExpirationTime($exam, getTimeExam($exam->questions()->count()));

        /**
         * Redirect to route.
         */

        return redirect()->route('exams.show', $exam);
    }

    /**
     * Store a newly created category exam in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionCategory  $question_category
     * @return \Illuminate\Http\Response
     */
    public function storeCategory(Request $request, QuestionCategory $question_category)
    {
        $user = User::findOrFail(Auth::id());

        /**
         * Check if the user has an exam in progress.
         */

        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }

        /**
         * Create and store the new exam.
         */

        $questions_count = $question_category
            ->questions
            ->where('active', '=', true)
            ->where('bank_questions', '=', 1)
            ->count();

        $questions = $question_category
            ->questions
            ->where('active', '=', true)
            ->where('bank_questions', '=', 1)
            ->random(min($questions_count, 25))
            ->shuffle();

        $exam = Exam::create([
            'public_id' => $this->createExamPublicId(),
            'question_category_id' => $question_category->id,
            'sharing_token' => Str::random(12),
            'type' => 'CATEGORY',
            'user_id' => $user->id,
        ]);

        $exam->questions()->saveMany($questions);

        UserActivityLog::create([
            'user_id' => $user->id,
            'activity_type_id' => ActivityType::where('name', 'USER_CREATED_EXAM')->first()->id,
            'object_id' => $exam->id,
        ]);

        /**
         * Send notifications.
         */

        $user->notify(new ExamCreated($exam));

        if ($user->study_id != '') setExpirationTime($exam, getTimeExam($exam->questions()->count()));

        /**
         * Redirect to route.
         */

        return redirect()->route('exams.show', $exam);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        /**
         * Check that user has access to exam.
         */

        $exam_belongs_to_user = Auth::id() == $exam->user->id;

        if (!$exam_belongs_to_user) {
            abort(401);
        }

        /**
         * Check if exam is already completed.
         */
        if (!session()->has('exam_expiration_time')) {
            $expiration_date = $exam->expiration_at;
            if (!isTimeExpired($expiration_date)) {
                session()->put('exam_expiration_time', $exam->expiration_at);
            }
        }


        if ($exam->isCompleted()) {
            $scores_by_subcategory = DB::table('exam_question')
                ->select(
                    DB::raw('ROUND(SUM(exam_question.correct) / COUNT(exam_question.correct) * 100) AS score'),
                    'questions.question_subcategory_id',
                    'question_subcategories.name',
                )
                ->join('questions', 'exam_question.question_id', 'questions.id')
                ->join('question_subcategories', 'questions.question_subcategory_id', 'question_subcategories.id')
                ->where('exam_question.exam_id', '=', $exam->id)
                ->groupBy('questions.question_subcategory_id')
                ->orderByDesc('score')
                ->orderBy('question_subcategories.name')
                ->get();

            return view('exams.show-review', [
                'exam' => $exam,
                'scores_by_subcategory' => $scores_by_subcategory,
                'user' => Auth::user(),
            ]);
        }

        /**
         * Show exam page.
         */

        return view('exams.show', [
            'exam' => $exam,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        if ($exam->completed_at) {
            $messageBag = new MessageBag();
            $messageBag->add('error', 'Un examen completado no puede ser cancelado.');
            return redirect()->back()->with('errors', $messageBag);
        }
        $user = User::findOrFail(Auth::id());

        UserActivityLog::create([
            'user_id' => $user->id,
            'activity_type_id' => ActivityType::where('name', 'USER_DELETED_EXAM')->first()->id,
            'object_id' => $exam->id,
            // 'value'=>$simulacrum->name
        ]);
        $exam->delete();
        session()->forget('exam_expiration_time');

        return redirect()
            ->back()
            ->with('success', 'El examen ha sido cancelado.');
    }

    /**
     * Display the question page, where the user can answer a question.
     *
     * @param  \App\Models\Exam  $exam
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function showQuestion(Exam $exam, Question $question)
    {
        /**
         * Check that user has access to exam, and question belongs to exam.
         */

        $exam_belongs_to_user = Auth::id() == $exam->user->id;
        $question_belongs_to_exam = $exam->questions->contains($question);

        if (!$exam_belongs_to_user || !$question_belongs_to_exam) {
            abort(401);
        }

        /**
         * Check if the exam is already completed.
         */

        if ($exam->isCompleted()) {
            return redirect()->route('exams.show', $exam);
        }

        /**
         * Calculate the next question to redirect after answering the current
         * one.
         */

        $exam_has_unanswered_questions = $exam->unanswered_questions()->count();

        if ($exam_has_unanswered_questions) {
            $exam_question_id = $exam->questions->find($question)->pivot->id;
            $unanswered_question_after_this = $exam->unanswered_questions()->where("exam_question.id", ">", $exam_question_id)->first();

            if ($unanswered_question_after_this) {
                $next_question_url = route('exams.show.question', [$exam, $unanswered_question_after_this]);
            } else {
                $unanswered_question_before_this = $exam->unanswered_questions()->where("exam_question.id", "<", $exam_question_id)->first();

                if ($unanswered_question_before_this) {
                    $next_question_url = route('exams.show.question', [$exam, $unanswered_question_before_this]);
                } else {
                    $next_question_url = route('exams.show', $exam);
                }
            }
        } else {
            $next_question_url = route('exams.show', $exam);
        }

        /**
         * Get question number.
         */

        $question_number = $exam->questions->search(function ($item) use ($question) {
            return $item->id === $question->id;
        }) + 1;

        /**
         * Calculate question difficulty.
         */

        $question_times_answered = DB::table('exam_question')
            ->where('question_id', $question->id)
            ->count();

        $question_times_answered_correctly = DB::table('exam_question')
            ->where('question_id', $question->id)
            ->where('correct', true)
            ->count();

        $question_times_answered_correctly_percentage = $question_times_answered_correctly / $question_times_answered;

        if ($question_times_answered_correctly_percentage > 2 / 3) {
            $question_difficulty = 'EASY';
        } elseif ($question_times_answered_correctly_percentage > 1 / 3) {
            $question_difficulty = 'MEDIUM';
        } else {
            $question_difficulty = 'HARD';
        }

        $saved_note = DB::table('question_note')->select()
            ->where('id_user', Auth::id())
            ->where('id_question', $question->id)
            ->first();

        $note = '';
        if ($saved_note) {
            $note = $saved_note->note;
        }

        /**
         * Show exam question view.
         */
        //BUSCAR SI TIENE RESPUESTA O NO
        $question_answer_response = ExamQuestion::select('answer_id')->where('exam_id', $exam->id)->where('question_id', $question->id)->first();


        return view('exams.show-question', [
            'exam' => $exam,
            'next_question_url' => $next_question_url,
            'question' => $question,
            'question_count' => $exam->questions()->count(),
            'question_difficulty' => $question_difficulty,
            'question_number' => $question_number,
            'note' => $note,
            'answer_response' => $question_answer_response
        ]);
    }

    /**
     * Finish the exam.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function finish(Exam $exam)
    {
        /**
         * Check that user has access to exam.
         */

        $exam_belongs_to_user = Auth::id() == $exam->user->id;

        if (!$exam_belongs_to_user) {
            abort(401);
        }

        /**
         * Calculate score.
         */

        $score = (int) round($exam->correct_questions->count() / $exam->questions->count() * 100);

        /**
         * Update exam in database.
         */
        $exam->total_correct_questions = $exam->correct_questions->count();
        $exam->total_questions = $exam->questions->count();
        $exam->total_incorrect_questions = $exam->incorrect_questions->count();
        $exam->completed_at = now();
        $exam->score = $score;
        $exam->save();


        /**
         * Redirect user.
         */
        session()->forget('exam_expiration_time');
        return redirect()->route('exams.show', $exam);
    }

    /**
     * Starts the countdown timer
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function countdown(Exam $exam)
    {
        $time = getTimeExam($exam->questions()->count());
        $exam->expiration_at = now()->addMinutes($time);
        $exam->save();
        session()->put('exam_expiration_time', $exam->expiration_at);
        return redirect()->route('exams.show', $exam);
    }

    public function finishExam(Exam $exam)
    {
        foreach ($exam->unanswered_questions()->get() as $question) {
            $correct_answer = $question->getCorrectAnswer();
            $exam_question = $exam->questions->find($question)->pivot;
            $exam_question->answer_id = $correct_answer->id;
            $exam_question->answered = 1;
            $exam_question->save();
        }
        session()->forget('exam_expiration_time');
    }

    public function saveNote(Request $request, Exam $exam, Question $question)
    {
        $note = $request->question_note;
        $saved_note = DB::table('question_note')->select()
            ->where('id_user', Auth::id())
            ->where('id_question', $question->id)
            ->count();

        if ($saved_note > 0) {
            DB::table('question_note')
                ->where('id_user', Auth::id())
                ->where('id_question', $question->id)
                ->update([
                    'note' => $note,
                ]);
        } else {
            DB::table('question_note')->insert([
                'id_user' => Auth::id(),
                'id_question' => $question->id,
                'note' => $note
            ]);
        }

        return redirect()->route('exams.show.question', [$exam, $question]);
    }
}
