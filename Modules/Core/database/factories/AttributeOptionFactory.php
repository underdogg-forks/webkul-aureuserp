<?php

namespace Modules\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\Models\Attribute;
use Modules\Core\Models\AttributeOption;
use Modules\Core\Models\User;

/**
 * @extends Factory<AttributeOption>
 */
class AttributeOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AttributeOption::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'         => fake()->name(),
            'full_name'    => fake()->name(),
            'sort'         => fake()->randomNumber(),
            'extra_price'  => fake()->randomFloat(2, 0, 100),
            'attribute_id' => Attribute::factory(),
            'creator_id'   => User::factory(),
        ];
    }
}
