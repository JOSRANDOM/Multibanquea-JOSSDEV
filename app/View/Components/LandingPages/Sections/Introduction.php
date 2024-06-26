<?php

namespace App\View\Components\LandingPages\Sections;

use Illuminate\View\Component;

class Introduction extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.landing-pages.sections.introduction-' . config('variant.name'));
    }
}
