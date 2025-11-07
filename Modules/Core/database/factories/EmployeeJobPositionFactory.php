<?php

namespace Modules\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\Models\Department;
use Modules\Core\Models\EmployeeJobPosition;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;

class EmployeeJobPositionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeJobPosition::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sort'               => $this->faker->randomNumber(),
            'name'               => $this->faker->word,
            'description'        => $this->faker->text,
            'requirements'       => $this->faker->text,
            'expected_employees' => $this->faker->randomNumber(),
            'no_of_employee'     => $this->faker->randomNumber(),
            'status'             => true,
            'no_of_recruitment'  => $this->faker->randomNumber(),
            'department_id'      => Department::factory(),
            'company_id'         => Company::factory(),
            'open_date'          => $this->faker->date(),
            'creator_id'         => User::factory(),
        ];
    }
}
