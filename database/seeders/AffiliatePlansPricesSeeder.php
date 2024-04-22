<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AffiliatePlansPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($months = 1; $months <= 12; $months++) {
            DB::table('affiliate_plans_prices')->insert([
                [
                    'months' => $months,
                    'monthly_price' => rand(500, 10000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
