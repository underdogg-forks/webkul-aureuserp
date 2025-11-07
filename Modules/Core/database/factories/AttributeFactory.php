<?php

namespace Modules\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\Enums\AttributeType;
use Modules\Core\Models\Attribute;
use Modules\Core\Models\User;

/**
 * @extends Factory<Attribute>
 */
class AttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attribute::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'       => fake()->name(),
            'type'       => AttributeType::RADIO,
            'sort'       => fake()->randomNumber(),
            'creator_id' => User::factory(),
        ];
    }
}
