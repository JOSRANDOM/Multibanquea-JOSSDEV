<?php

namespace Database\Factories;

use App\Models\QuestionCategory;
use App\Models\QuestionSubcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionSubcategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuestionSubcategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'question_category_id' => QuestionCategory::all()->random(),
        ];
    }
}
