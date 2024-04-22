<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $user) {
            $user_should_have_subscriptions = rand(0, 1);

            if ($user_should_have_subscriptions) {
                $subscriptions_count = rand(1, 3);

                Subscription::factory()
                    ->count($subscriptions_count)
                    ->state([
                        'user_id' => $user->id
                    ])
                    ->create();
            }
        }
    }
}
