<?php

namespace Database\Factories\Shop;

use Akaunting\Money\Currency;
use App\Models\Shop\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Current;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Payment::class;
    
    public function definition(): array
    {
        return [
            'reference' => 'PAY' . $this->faker->unique()->randomNumber(6),
            'currency' => $this->faker->randomElement(collect(Currency::getCurrencies())->keys()),
            'amount' => $this->faker->randomFloat(1000, 50000, 100000),
            'provider' => $this->faker->randomElement(['stripe', 'paypal']),
            'method' => $this->faker->randomElement(['credit_card', 'bank_transfer', 'paypal']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}
