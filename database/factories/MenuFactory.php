<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'category' => fake()->randomElement(['makanan', 'minuman']),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(5000, 50000),
            'image' => null,
            'is_available' => true,
        ];
    }
}
