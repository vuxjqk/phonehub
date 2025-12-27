<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        $price = fake()->numberBetween(3_000, 30_000);
        $salePrice = fake()->boolean(75)
            ? fake()->randomFloat(2, 0.75, 0.9) * $price
            : null;

        return [
            'name'           => ucfirst($name),
            'slug'           => Str::slug($name),
            'brand_id'       => fake()->numberBetween(1, 5),
            'price'          => $price * 1000,
            'sale_price'     => $salePrice ? $salePrice * 1000 : null,
            'stock'          => fake()->numberBetween(0, 100),
            'is_active'      => fake()->boolean(90),
            'description'    => fake()->optional(0.75)->paragraph(),
            'specifications' => fake()->boolean(75)
                ? [
                    'color'   => fake()->randomElement(['Đen', 'Trắng', 'Xanh']),
                    'cpu'     => fake()->randomElement(['Snapdragon', 'Apple A', 'Dimensity']),
                    'ram'     => fake()->randomElement(['8GB', '12GB', '16GB']),
                    'storage' => fake()->randomElement(['128GB', '256GB', '512GB']),
                ]
                : null,
        ];
    }
}
