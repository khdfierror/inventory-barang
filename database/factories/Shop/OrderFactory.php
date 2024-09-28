<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'number' => 'OR' . $this->faker->unique()->randomNumber(6),
            'currency' => strtolower($this->faker->currencyCode('IDR')),
            'total_price' => $this->faker->randomFloat(2, 1000, 20000),
            'status' => $this->faker->randomElement(['new', 'processing', 'shipped', 'delivered', 'cancelled']),
            'shipping_price' => $this->faker->randomFloat(2, 1000, 20000),
            'shipping_method' => $this->faker->randomElement(['free', 'flat', 'flat_rate', 'flat_rate_per_item']),
            'address' => $this->faker->address(),
            'notes' => $this->faker->realText(100),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}
