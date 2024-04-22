<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;

class CardUserExamsScoreProgress extends Component
{
    public $chartData;
    public $headline;
    public $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(object $chartData, string $headline, User $user)
    {
        $this->chartData = $chartData;
        $this->headline = $headline;
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.card-user-exams-score-progress');
    }
}
