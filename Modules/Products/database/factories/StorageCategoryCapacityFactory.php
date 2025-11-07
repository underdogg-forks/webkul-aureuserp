<?php

namespace Modules\Products\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Products\Models\StorageCategoryCapacity;
use Modules\Core\Models\User;

/**
 * @extends Factory<StorageCategoryCapacity>
 */
class StorageCategoryCapacityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StorageCategoryCapacity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'creator_id' => User::factory(),
        ];
    }
}
