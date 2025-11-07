<?php

namespace Modules\Crm\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Crm\Models\Industry;
use Modules\Core\Models\User;

/**
 * @extends Factory<Industry>
 */
class IndustryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Industry::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'           => fake()->name(),
            'description'    => fake()->sentence(),
            'is_active'      => true,
            'can_send_money' => true,
            'creator_id'     => User::factory(),
        ];
    }
}
