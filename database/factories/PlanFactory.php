<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Plan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->unique()->slug($nbWords = 4, $variableNbWords = true),
            'promo_code' => $this->faker->randomElement([
                null,
                Str::upper($this->faker->lexify('????????????????????')),
            ]),
            'user_id' => $this->faker->randomElement([
                null,
                User::all()->random(),
            ]),
            'name' => $this->faker->words($nb = 3, $asText = true),
            'months' => $this->faker->numberBetween($min = 1, $max = 3),
            'monthly_price' => $this->faker->numberBetween($min = 90, $max = 990) * 10,
            'active' => $this->faker->boolean(),
            'public' => $this->faker->boolean(),
            'protected' => $this->faker->boolean(),
            'featured' => $this->faker->boolean(),
        ];
    }
}
