<?php

namespace Database\Factories;

use App\Models\LendingOpenPosition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LendingOpenPosition>
 */
class LendingOpenPositionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LendingOpenPosition::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => now(),
            'paper' => Str::random(rand(5, 6)),
            'asset_role' => Str::random(4),
            'balance_amount' => rand(1, 100),
            'average_price' => rand(1, 100),
            'price_factor' => rand(1, 100),
            'total_balance' => rand(1, 100),
        ];
    }
}
