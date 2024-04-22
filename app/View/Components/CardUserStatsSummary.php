<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class CardUserStatsSummary extends Component
{
    public $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        // Auth::id()
        $user = User::findOrFail(Auth::id());

        $questions_answered = DB::table('exam_question')
            ->join('exams', 'exam_question.exam_id', 'exams.id')
            ->join('questions', 'exam_question.question_id', 'questions.id')
            ->where('exams.user_id', $user->id)
            ->whereNotNull('exams.completed_at')
            ->select('questions.id')
            ->count();

        $questions_answered_correctly = DB::table('exam_question')
            ->join('exams', 'exam_question.exam_id', 'exams.id')
            ->join('questions', 'exam_question.question_id', 'questions.id')
            ->where('exams.user_id', $user->id)
            ->whereNotNull('exams.completed_at')
            ->where('exam_question.correct', 1)
            ->select('questions.id')
            ->count();

        return view('components.card-user-stats-summary', [
            'exams_completed_count' => $user->exams_completed->count(),
            'latest_exam_completed' => $user->exams_completed->sortByDesc('completed_at')->first(),
            'questions_answered' => $questions_answered,
            'questions_answered_correctly' => $questions_answered_correctly,
        ]);
    }
}
