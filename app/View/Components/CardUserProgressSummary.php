<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class CardUserProgressSummary extends Component
{
    public $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $questions_answered = DB::table('exam_question')
            ->join('exams', 'exam_question.exam_id', 'exams.id')
            ->join('questions', 'exam_question.question_id', 'questions.id')
            ->where('exams.user_id', $this->user->id)
            ->whereNotNull('exams.completed_at')
            ->select('questions.id')
            ->count();

        $questions_answered_correctly = DB::table('exam_question')
            ->join('exams', 'exam_question.exam_id', 'exams.id')
            ->join('questions', 'exam_question.question_id', 'questions.id')
            ->where('exams.user_id', $this->user->id)
            ->whereNotNull('exams.completed_at')
            ->where('exam_question.correct', 1)
            ->select('questions.id')
            ->count();

        return view('components.card-user-progress-summary', [
            'exams_completed_count' => $this->user->exams_completed->count(),
            'latest_exam_completed' => $this->user->exams_completed->sortByDesc('completed_at')->first(),
            'questions_answered' => $questions_answered,
            'questions_answered_correctly' => $questions_answered_correctly,
        ]);
    }
}
