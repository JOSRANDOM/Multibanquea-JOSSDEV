<?php

namespace App\View\Components;

use App\Models\Exam;
use Illuminate\View\Component;

class ModalCancelExam extends Component
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
        return view('components.modal-cancel-exam');
    }
}
