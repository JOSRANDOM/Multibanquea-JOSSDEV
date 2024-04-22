<?php

namespace App\View\Components;

use App\Models\Question;
use App\Models\User;
use Illuminate\View\Component;

class CardReportQuestionProblem extends Component
{
    public $question;
    public $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Question $question, User $user)
    {
        $this->question = $question;
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.card-report-question-problem');
    }
}
