<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionSubcategory;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (QuestionSubcategory::all() as $question_subcategory) {
            Question::factory()
                ->count(50)
                ->state([
                    'question_subcategory_id' => $question_subcategory
                ])
                ->create();
        }
    }
}
