<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use App\Models\Exam;
use App\Models\QuestionCategory;

class CardUserStatsExamDetail extends Component
{
    public $exam;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $subcategories_data = DB::table('exam_question')
                    ->select(
                        'questions.question_subcategory_id',
                        'question_subcategories.name',
                        'question_categories.name as category_name',
                        'question_categories.id as category_id',
                        'question_subcategories.question_category_id',
                        DB::raw('ROUND(SUM(exam_question.correct) / COUNT(exam_question.correct) * 100) AS score'),
                        DB::raw(' SUM(exam_question.correct) AS correct_question'),
                        DB::raw(' COUNT(exam_question.correct) AS total')
                    )
                    ->join('questions', 'exam_question.question_id', 'questions.id')
                    ->join('question_subcategories', 'questions.question_subcategory_id', 'question_subcategories.id')
                    ->join('question_categories', 'question_subcategories.question_category_id', 'question_categories.id')
                    ->where('exam_question.exam_id', '=', $this->exam->id)
                    // ->where('question_subcategories.question_category_id', $type)
                    ->groupBy('questions.question_subcategory_id')
                    ->orderByDesc('score')
                    // ->orderBy('question_subcategories.name')
                    ->get();
        $data_question = [];
        foreach ($subcategories_data as $key => $v) {
            if(!isset($data_question[$v->category_id])){
                $data_question[$v->category_id] = [
                                                    'name' => $v->category_name,
                                                    'total' => 0,
                                                    'correct_question' => 0,
                                                    'subcategories' => []
                                                    ];
            }
            $data_question[$v->category_id]['total'] += $v->total;
            $data_question[$v->category_id]['correct_question'] += $v->correct_question;
            $data_question[$v->category_id]['subcategories'][]=[ 'name' => $v->name,'score'=> $v->score,'total'=>$v->total,'correct_question'=>$v->correct_question ];

        }
        // dd($data_question);

        $categories = QuestionCategory::pluck('name','id');
        return view('components.card-user-stats-exam-detail', [
            'exam' => $this->exam,
            'categories' => $categories,

            'data_questions'=>$data_question
        ]);
    }
}
