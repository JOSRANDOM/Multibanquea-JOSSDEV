<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\QuestionSubcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question_subcategory_id' => QuestionSubcategory::all()->random(),
            'text' => $this->faker->sentence,
            'source' => $this->faker->randomElement([null, $this->faker->words($nb = 2, $asText = true)]),
            'active' => $this->faker->boolean(),
        ];
    }
}
