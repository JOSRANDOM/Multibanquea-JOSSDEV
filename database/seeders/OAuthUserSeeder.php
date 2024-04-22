<?php

namespace Database\Seeders;

use App\Models\OAuthUser;
use Illuminate\Database\Seeder;

class OAuthUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OAuthUser::factory()
            ->times(200)
            ->create();
    }
}
