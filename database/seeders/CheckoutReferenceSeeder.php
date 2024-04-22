<?php

namespace Database\Seeders;

use App\Models\CheckoutReference;
use Illuminate\Database\Seeder;

class CheckoutReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CheckoutReference::factory()
            ->times(100)
            ->create();
    }
}
