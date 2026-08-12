<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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

        $purchasePirce = fake()->numberBetween(2000, 50000);
        $sellingPrice = $purchasePirce + fake()->numberBetween(1000, 100000);
        return [
            'category_id' => Category::factory(),
            'code' => 'PRD-' . fake()->unique()->numerify('#####'),
            'name' => fake()->randomElement([
                'Indomie Goreng',
                'Indomie Soto',
                'Teh Botol',
                'Aqua 600ml',
                'Coca cola',
                'Chitato',
                'Oreo',
                'Beras 5kg',
                'Gula 1Kg',
                'Minyak Goreng 1L',
            ]),

            'description' => fake()->sentence(),
            'purchase_price' => $purchasePirce,
            'selling_price' => $sellingPrice,
            'stock' => fake()->numberBetween(10, 100),
            'minimum_stock' => fake()->numberBetween(5, 10),
            'unit' => fake()->randomElement([
                'pcs',
                'box',
                'kg',
                'liter',
            ]),
            'image' => null,
            'is_active' => true,
        ];
    }
}
