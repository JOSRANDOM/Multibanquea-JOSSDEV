<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity_types')->insert([
            [
                'name' => 'USER_REGISTERED',
                'object_type' => null,
            ],
            [
                'name' => 'USER_LOGGED_IN',
                'object_type' => null,
            ],
            [
                'name' => 'USER_CREATED_EXAM',
                'object_type' => 'EXAM',
            ],
            [
                'name' => 'USER_CREATED_SUBSCRIPTION',
                'object_type' => 'SUBSCRIPTION',
            ],
        ]);
    }
}
