<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Question::all() as $question) {
            /**
             * Incorrect answers.
             */
            Answer::factory()
                ->count(4)
                ->state([
                    'question_id' => $question,
                    'correct' => 0,
                ])
                ->create();

            /**
             * Correct answer.
             */
            Answer::factory()
                ->state([
                    'question_id' => $question,
                    'correct' => 1,
                ])
                ->create();
        }
    }
}
