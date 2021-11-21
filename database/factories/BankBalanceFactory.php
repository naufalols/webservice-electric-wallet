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
            'balance' => 20000,
            'balance_archieve' => 0,
            'code' => Str::random(6),
            'enable' => true,
        ];
    }
}
