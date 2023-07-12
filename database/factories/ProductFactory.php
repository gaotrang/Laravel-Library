<?php

namespace Database\Factories;

use App\Models\ProductCategory;
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
        $name = fake()->name;
        $slug = Str::slug($name);
        $arrayCategoryIds = ProductCategory::all()->pluck('id');
        $productCategoryId = fake()->randomElement($arrayCategoryIds);
        return [
            'name'=> $name,
            'slug'=>$slug,
            'price'=> fake()->numberBetween(10, 1000),
            'discount_price'=>fake()->numberBetween(10, 1000),
            'description'=>fake()->text,
            'short_description'=>fake()->text,
            'information'=>fake()->text,
            'qty'=>fake()->numberBetween(10, 1000),
            'shipping'=> fake()->text,
            'weight'=>fake()->randomFloat(2,0,10),
            'status'=>fake()->numberBetween(0, 1),

            'product_category_id'=> $productCategoryId
        ];
    }
}
