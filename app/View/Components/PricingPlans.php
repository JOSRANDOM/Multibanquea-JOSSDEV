<?php

namespace App\View\Components;

use App\Models\Plan;
use Illuminate\View\Component;

class PricingPlans extends Component
{
    public $plan1;
    public $plan2;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Plan $plan1, Plan $plan2)
    {
        $this->plan1 = $plan1;
        $this->plan2 = $plan2;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.pricing-plans');
    }
}
