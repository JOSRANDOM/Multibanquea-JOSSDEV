<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exam::class;

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Exam $exam) {
            $questions = Question::all()->random(rand(5, 10));

            foreach ($questions as $question) {
                $answer = $question->answers()->inRandomOrder()->first();

                DB::table('exam_question')->insert([
                    'exam_id' => $exam->id,
                    'question_id' => $question->id,
                    'answer_id' => $answer->id,
                    'correct' => $answer->correct,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question_category_id' => QuestionCategory::all()->random(),
            'user_id' => User::all()->random(),
            'public_id' => $this->faker->unique()->bothify('??#?#???###?'),
            'type' => $this->faker->randomElement(['STANDARD', 'BALANCED', 'CATEGORY']),
            'score' => $this->faker->numberBetween($min = 0, $max = 100),
            'sharing_token' => Str::random(12),
            'completed_at' => $this->faker->time($format = 'Y-m-d H:i:s', $max = 'now'),
            'utm_source' => $this->faker->randomElement([null, $this->faker->word]),
            'utm_medium' => $this->faker->randomElement([null, $this->faker->word]),
            'utm_campaign' => $this->faker->randomElement([null, $this->faker->word]),
            'utm_term' => $this->faker->randomElement([null, $this->faker->word]),
            'utm_content' => $this->faker->randomElement([null, $this->faker->word]),
        ];
    }
}
