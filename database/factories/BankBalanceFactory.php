<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BankBalanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'balance' => $this->faker->numberBetween($min = 1000, $max = 2000000),
            'balance_archieve' => $this->faker->numberBetween($min = 1000, $max = 2000000),
            'code' => Str::random(6),
            'enable' => true,
        ];
    }
}
