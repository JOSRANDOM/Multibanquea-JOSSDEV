<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardUpgrade extends Component
{
    public $showCta;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($showCta = true)
    {
        $this->showCta = $showCta;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.card-upgrade');
    }
}
