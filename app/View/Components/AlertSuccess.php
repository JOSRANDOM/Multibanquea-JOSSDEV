<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AlertSuccess extends Component
{
    public $message;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.alert-success');
    }
}
