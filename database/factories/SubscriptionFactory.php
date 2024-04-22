<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $is_old_subscription = rand(0, 1);

        if ($is_old_subscription) {
            $ends_at_carbon = Carbon::now()->subDays(rand(1, 180));
        } else {
            $ends_at_carbon = Carbon::now()->addDays(rand(1, 180));
        }

        $plan = Plan::all()->random();

        $starts_at_carbon = $ends_at_carbon->copy()->subMonths($plan->months);

        $ends_at = $ends_at_carbon->toDateString();
        $starts_at = $starts_at_carbon->toDateString();

        return [
            'user_id' => User::all()->random(),
            'plan_id' => $plan->id,
            'starts_at' => $starts_at,
            'ends_at' => $ends_at,
            'utm_source' => $this->faker->randomElement([null, $this->faker->word]),
            'utm_medium' => $this->faker->randomElement([null, $this->faker->word]),
            'utm_campaign' => $this->faker->randomElement([null, $this->faker->word]),
            'utm_term' => $this->faker->randomElement([null, $this->faker->word]),
            'utm_content' => $this->faker->randomElement([null, $this->faker->word]),
        ];
    }
}
