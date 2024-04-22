<?php

namespace Database\Seeders;

use App\Models\UserActivityLog;
use Illuminate\Database\Seeder;

class UserActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserActivityLog::factory()
            ->times(1000)
            ->create();
    }
}
