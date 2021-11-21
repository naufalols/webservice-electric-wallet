<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserBalanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::pluck('id');

        return [
            'userid' => $this->faker->unique()->randomElement($user),
            'balance' => 0,
            'balanceArchieve' => 0,
            // 'balance' => $this->faker->numberBetween($min = 1000, $max = 10000),
            // 'balanceArchieve' => $this->faker->numberBetween($min = 1000, $max = 2000000),
        ];
    }
}
