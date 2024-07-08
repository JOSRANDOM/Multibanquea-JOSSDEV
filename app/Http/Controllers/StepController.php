<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Models\User;
use App\Models\Exam;
use App\Models\Question;
use App\Models\ActivityType;
use App\Models\UserActivityLog;
use App\Models\UserStep;
use App\Notifications\ExamCreated;
use Illuminate\Support\Str;

class StepController extends Controller
{
    private $errorMessages = [
        'user-has-product-exam-in-progress' => 'You already have an exam in progress.'
    ];

    public function createBalanced()
    {
        $user = User::findOrFail(Auth::id());

        // Check if the user has an exam in progress.
        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }

        // Available exam sizes.
        $exam_sizes = DB::table('balanced_exam_categories')
            ->select('type', DB::raw('SUM(size) AS questions'))
            ->groupBy('type')
            ->orderBy('questions')
            ->get()
            ->pluck('questions', 'type');

        // Display view.
        return view('exams.create-balanced', [
            'exam_sizes' => $exam_sizes,
        ]);
    }

    public function storeBalanced(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        // Check if the user has an exam in progress.
        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }

        // Create and store the new exam.
        $question_categories_sizes = DB::table('balanced_exam_categories')
            ->where('type', '=', 'NORMAL')
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

        $userStep = UserStep::where('user_id', $user->id)->first();

        if ($userStep) {
            // Update existing user step record
            $userStep->step_1 = 1;
            $userStep->updated_at = now();
            $userStep->updated_by = Auth::id();
            $userStep->exams_id = $exam->id;
            $userStep->save();
        }

        // Send notifications.
        $user->notify(new ExamCreated($exam));

        if ($user->study_id != '') setExpirationTime($exam, getTimeExam($exam->questions()->count()));

        // Redirect to the newly created exam.
        return redirect()->route('exams.show', $exam);
    }

    public function storeBalanced2(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        // Check if the user has an exam in progress.
        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', $this->errorMessages['user-has-product-exam-in-progress']);
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }

        // Create and store the new exam.
        $question_categories_sizes = DB::table('balanced_exam_categories')
            ->where('type', '=', 'NORMAL')
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

        $userStep = UserStep::where('user_id', $user->id)->first();

        if ($userStep) {
            // Update existing user step record
            $userStep->step_2 = 1;
            $userStep->updated_at = now();
            $userStep->updated_by = Auth::id();
            $userStep->exams_id = $exam->id;
            $userStep->save();
        }

        // Send notifications.
        $user->notify(new ExamCreated($exam));

        if ($user->study_id != '') setExpirationTime($exam, getTimeExam($exam->questions()->count()));

        // Redirect to the newly created exam.
        return redirect()->route('exams.show', $exam);
    }

    private function createExamPublicId()
    {
        return 'EXAM-' . strtoupper(Str::random(10));
    }
}
