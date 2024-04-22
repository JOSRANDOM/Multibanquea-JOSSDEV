<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Title extends Component
{

    public $label;
    public $description;
    public $previousUrl;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $description = null, $previousUrl = null)
    {
        $this->label = $label;
        $this->description = $description;
        $this->previousUrl = $previousUrl;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.title');
    }
}
