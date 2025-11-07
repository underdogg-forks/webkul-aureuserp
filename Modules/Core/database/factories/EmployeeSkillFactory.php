<?php

namespace Modules\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\Models\Employee;
use Modules\Core\Models\EmployeeSkill;
use Modules\Core\Models\Skill;
use Modules\Core\Models\SkillLevel;

class EmployeeSkillFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeSkill::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id'    => Employee::factory(),
            'skill_id'       => Skill::factory(),
            'skill_level_id' => SkillLevel::factory(),
            'start_date'     => $this->faker->date(),
            'notes'          => $this->faker->text(),
        ];
    }
}
