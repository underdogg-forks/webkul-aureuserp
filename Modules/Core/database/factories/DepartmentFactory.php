<?php

namespace Modules\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\Models\Department;
use Modules\Core\Models\Employee;
use Modules\Core\Models\Company;

class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'       => $this->faker->name,
            'manager_id' => Employee::factory(),
            'company_id' => Company::factory(),
            'color'      => $this->faker->hexColor,
        ];
    }
}
