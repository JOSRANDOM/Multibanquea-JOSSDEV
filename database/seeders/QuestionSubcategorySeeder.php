<?php

namespace Database\Seeders;

use App\Models\QuestionCategory;
use App\Models\QuestionSubcategory;
use Illuminate\Database\Seeder;

class QuestionSubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (QuestionCategory::all() as $question_category) {
            QuestionSubcategory::factory()
                ->count(rand(1, 5))
                ->state([
                    'question_category_id' => $question_category
                ])
                ->create();
        }
    }
}
