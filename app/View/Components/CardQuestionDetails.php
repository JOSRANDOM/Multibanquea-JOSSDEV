<?php

namespace App\View\Components;

use App\Models\Question;
use Illuminate\View\Component;

class CardQuestionDetails extends Component
{
    public $difficulty;
    public $question;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $difficulty, Question $question)
    {
        $this->difficulty = $difficulty;
        $this->question = $question;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        switch ($this->difficulty) {
            case 'EASY':
                $difficulty_icon = 'fa-thermometer-empty';
                $difficulty_label = 'Fácil';
                break;
            case 'MEDIUM':
                $difficulty_icon = 'fa-thermometer-half';
                $difficulty_label = 'Intermedia';
                break;
            default:
                $difficulty_icon = 'fa-thermometer-full';
                $difficulty_label = 'Difícil';
                break;
        }

        return view('components.card-question-details', [
            'difficulty_icon' => $difficulty_icon,
            'difficulty_label' => $difficulty_label,
        ]);
    }
}
