<?php

namespace App\View\Components;

use App\Models\Plan;
use Illuminate\View\Component;

class Pricing extends Component
{
    public $breakpoint;
    public $darkLayout;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $breakpoint = 'md', bool $darkLayout = false)
    {
        $this->breakpoint = $breakpoint;
        $this->darkLayout = $darkLayout;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $plan_1 = Plan::find(env('PLAN_1'));
        $plan_2 = Plan::find(env('PLAN_2'));
        $plan_3 = Plan::find(env('PLAN_3'));
        // dd( $plan_1, $plan_2, $plan_3);
        $plan_1_has_discount = $plan_1->monthly_price < config('variant.regular_monthly_price');
        $plan_2_has_discount = $plan_2->monthly_price < config('variant.regular_monthly_price');
        $plan_3_has_discount = $plan_3->monthly_price < config('variant.regular_monthly_price');

        return view('components.pricing', [
            'plan_1' => $plan_1,
            'plan_2' => $plan_2,
            'plan_3' => $plan_3,
            'plan_1_has_discount' => $plan_1_has_discount,
            'plan_2_has_discount' => $plan_2_has_discount,
            'plan_3_has_discount' => $plan_3_has_discount
        ]);
    }
}
