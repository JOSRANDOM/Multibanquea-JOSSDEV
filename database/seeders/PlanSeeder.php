<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Basic plans.
         */

        $plans_slugs = [
            'afiliados',
            'colaborador',
            'pago-manual',
            'sorteo',
            'trabajador',
        ];

        foreach ($plans_slugs as $plan_slug) {
            DB::table('plans')->insert([
                [
                    'slug' => $plan_slug,
                    'name' => 'Acceso total',
                    'months' => 1,
                    'monthly_price' => 0,
                    'active' => true,
                    'protected' => true,
                ],
            ]);
        }

        /**
         * Mock plans.
         */

        Plan::factory()
            ->times(10)
            ->create();
    }
}
