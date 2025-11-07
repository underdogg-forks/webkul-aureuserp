<?php

namespace Modules\Projects\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Crm\Models\Partner;
use Modules\Projects\Models\Project;
use Modules\Projects\Models\ProjectStage;
use Modules\Core\Models\User;
use Modules\Core\Models\Company;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string => , mixed>
     */
    public function definition(): array
    {
        return [
            'name'                    => fake()->name(),
            'description'             => fake()->sentence(),
            'tasks_label'             => 'Tasks',
            'visibility'              => 'public',
            'color'                   => fake()->hexColor(),
            'sort'                    => fake()->randomNumber(),
            'start_date'              => fake()->date(),
            'end_date'                => fake()->date(),
            'allocated_hours'         => fake()->randomNumber(),
            'allow_timesheets'        => true,
            'allow_milestones'        => false,
            'allow_task_dependencies' => false,
            'is_active'               => true,
            'stage_id'                => ProjectStage::factory(),
            'partner_id'              => Partner::factory(),
            'company_id'              => Company::factory(),
            'user_id'                 => User::factory(),
            'creator_id'              => User::factory(),
        ];
    }
}
