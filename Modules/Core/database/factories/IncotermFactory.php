<?php

namespace Modules\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\Models\User;

class IncotermFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'       => $this->faker->word,
            'code'       => $this->faker->word,
            'creator_id' => User::factory(),
        ];
    }
}
