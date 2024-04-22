<?php

namespace Database\Seeders;

use App\Models\QuestionCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuestionCategory::factory()
            ->times(20)
            ->create();

        $this->seedBalancedExamCategories();
    }

    /**
     * Add question categories ratio to balanced exams.
     */
    private function seedBalancedExamCategories()
    {
        $question_categories = QuestionCategory::all();

        $question_categories->each(function ($question_category) {
            $small_size = rand(1, 5);

            DB::table('balanced_exam_categories')->insert([
                [
                    'question_category_id' => $question_category->id,
                    'size' => $small_size * 2,
                    'type' => 'NORMAL',
                ],
                [
                    'question_category_id' => $question_category->id,
                    'size' => $small_size,
                    'type' => 'SMALL',
                ],
            ]);
        });
    }
}
