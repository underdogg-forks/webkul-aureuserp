<?php

namespace Modules\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\Enums\ProductType;
use Modules\Core\Models\Category;
use Modules\Core\Models\Product;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type'                 => ProductType::GOODS,
            'name'                 => fake()->name(),
            'barcode'              => fake()->ean13(),
            'price'                => fake()->randomFloat(2, 0, 100),
            'cost'                 => fake()->randomFloat(2, 0, 100),
            'volume'               => fake()->randomFloat(2, 0, 100),
            'weight'               => fake()->randomFloat(2, 0, 100),
            'description'          => fake()->sentence(),
            'description_purchase' => fake()->sentence(),
            'description_sale'     => fake()->sentence(),
            'enable_sales'         => true,
            'sort'                 => fake()->randomNumber(),
            'category_id'          => Category::factory(),
            'creator_id'           => User::factory(),
            'company_id'           => Company::factory(),
        ];
    }
}
