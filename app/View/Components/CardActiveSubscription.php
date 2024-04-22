<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;

class CardActiveSubscription extends Component
{
    public $user;
    public $showCta;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(User $user, $showCta = true)
    {
        $this->user = $user;
        $this->showCta = $showCta;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.card-active-subscription');
    }
}
