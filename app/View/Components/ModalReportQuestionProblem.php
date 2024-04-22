<?php

namespace App\View\Components;

use App\Models\Question;
use Illuminate\View\Component;

class ModalReportQuestionProblem extends Component
{
    public $question;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modal-report-question-problem');
    }
}
