<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Order> */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $subtotal = fake()->numberBetween(200, 2000) * 1000;

        return [
            'order_number' => 'HRN-'.now()->format('ymd').'-'.strtoupper(fake()->unique()->bothify('????')),
            'customer_name' => fake()->name(),
            'customer_phone' => '08'.fake()->numerify('##########'),
            'customer_email' => fake()->safeEmail(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'province' => 'Jawa Barat',
            'postal_code' => fake()->postcode(),
            'subtotal' => $subtotal,
            'shipping_cost' => 0,
            'total' => $subtotal,
            'status' => 'pending',
        ];
    }
}
