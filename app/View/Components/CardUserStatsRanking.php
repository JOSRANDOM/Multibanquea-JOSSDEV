<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use App\Models\Exam;

class CardUserStatsRanking extends Component
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

        $type = $this->exam->type;
        $question_category_id = $this->exam->question_category_id;
        $date_star = \Carbon\Carbon::parse( $this->exam->completed_at)->startOfMonth()->format('Y-m-d 00:00:00') ;
        $date_end = \Carbon\Carbon::parse( $this->exam->completed_at)->format('Y-m-t 23:59:59');

        $ranking = Exam::with(['user'])
                        ->where('type',$type)
                        ->where('question_category_id',$question_category_id)
                        ->where('total_questions',$this->exam->total_questions)
                        ->whereBetween('completed_at',[$date_star,$date_end])
                        ->orderBy('total_correct_questions','DESC')
                        ->get();
        // dd($ranking);]

        return view('components.card-user-stats-ranking', [
            'exam' => $this->exam,
            'ranking' => $ranking
        ]);
    }
}
