<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'customer_name' => fake()->name(),
            'phone' => fake()->numerify('08##########'),
            'address' => fake()->address(),
            'notes' => null,
            'total_price' => fake()->numberBetween(10000, 100000),
            'status' => 'pending',
            'payment_method' => 'kasir',
            'payment_proof' => null,
            'is_read' => false,
        ];
    }
}
