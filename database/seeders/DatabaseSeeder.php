<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            OAuthUserSeeder::class,
            QuestionCategorySeeder::class,
            QuestionSubcategorySeeder::class,
            QuestionSeeder::class,
            AnswerSeeder::class,
            ExamSeeder::class,
            AffiliatePlansPricesSeeder::class,
            PlanSeeder::class,
            SubscriptionSeeder::class,
            CheckoutReferenceSeeder::class,
            ActivityTypeSeeder::class,
            UserActivityLogSeeder::class,
            PermissionSeeder::class,
        ]);
    }
}
