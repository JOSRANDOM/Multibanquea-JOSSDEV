<?php

namespace Database\Factories;

use App\Models\OAuthUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OAuthUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OAuthUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $is_linked_to_user = $this->faker->boolean();

        if ($is_linked_to_user) {
            $user = User::all()->random();
            $user_id = $user->id;
            $name = $user->name;
            $email = $user->email;
        } else {
            $user_id = null;
            $name = $this->faker->name();
            $email = $this->faker->safeEmail;
        }

        $provider = $this->faker->randomElement(['facebook', 'google']);
        $provider_id = Str::random(12);
        $nickname = $this->faker->firstName();
        $email_requested_request_token = Str::random(12);
        $email_requested_response_token = Str::random(12);
        $avatar = 'https://i.pravatar.cc/150?u=' . Str::random(12);

        return [
            'user_id' => $user_id,
            'provider' => $provider,
            'provider_id' => $provider_id,
            'nickname' => $this->faker->randomElement([null, $nickname]),
            'name' => $name,
            'email' => $this->faker->randomElement([null, $email]),
            'email_requested' => $this->faker->randomElement([null, $email]),
            'email_requested_request_token' => $this->faker->randomElement([null, $email_requested_request_token]),
            'email_requested_response_token' => $this->faker->randomElement([null, $email_requested_response_token]),
            'email_requested_response_token_created_at' => $this->faker->randomElement([null, now()]),
            'avatar' => $avatar,
        ];
    }
}
