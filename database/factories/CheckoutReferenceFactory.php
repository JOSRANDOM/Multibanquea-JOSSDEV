<?php

namespace Database\Factories;

use App\Models\CheckoutReference;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CheckoutReferenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CheckoutReference::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $plan = Plan::where('public', true)->get()->random();
        $total_price = $plan->monthly_price * $plan->months;

        return [
            'user_id' => User::all()->random(),
            'plan_id' => $plan,
            'total_price' => $total_price,
            'amount_paid' => $this->faker->randomElement([0, $total_price, $this->faker->numberBetween(100, $total_price)]),
        ];
    }
}
