<?php

namespace App\View\Components;

use App\Models\QuestionCategory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class CardUserSubcategoriesProgress extends Component
{
    public $question_category;
    public $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(QuestionCategory $questionCategory, User $user)
    {
        $this->question_category = $questionCategory;
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $question_subcategories_scores = DB::table('question_categories')
            ->select(
                'question_subcategories.id AS question_subcategory_id',
                'question_subcategories.name AS question_subcategory_name',
                DB::raw('COUNT(exam_question.question_id) AS questions'),
                DB::raw('SUM(exam_question.correct) AS correct_questions'),
                DB::raw('COUNT(exam_question.question_id) - SUM(exam_question.correct) AS incorrect_questions'),
                DB::raw('ROUND(SUM(exam_question.correct) / COUNT(exam_question.correct) * 100) AS score'),
            )
            ->join('question_subcategories', 'question_subcategories.question_category_id', 'question_categories.id')
            ->join('questions', 'questions.question_subcategory_id', 'question_subcategories.id')
            ->join('exam_question', 'exam_question.question_id', 'questions.id')
            ->join('exams', 'exams.id', 'exam_question.exam_id')
            ->where('exams.user_id', $this->user->id)
            ->where('question_subcategories.question_category_id', $this->question_category->id)
            ->whereNotNull('exams.completed_at')
            ->groupBy('question_subcategory_id')
            ->orderBy('question_subcategory_name')
            ->get();

        return view('components.card-user-subcategories-progress', [
            'question_subcategories_scores' => $question_subcategories_scores,
        ]);
    }
}
