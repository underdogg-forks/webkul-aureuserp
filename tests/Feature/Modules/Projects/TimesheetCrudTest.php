<?php

namespace Tests\Feature\Modules\Projects;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Crm\Models\Partner;
use Modules\Projects\Filament\Resources\TimesheetResource\Pages\ManageTimesheets;
use Modules\Projects\Models\Project;
use Modules\Projects\Models\Task;
use Modules\Projects\Models\Timesheet;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[Group('smoke')]
class TimesheetCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Company $company;

    protected Currency $currency;

    protected Project $project;

    protected Task $task;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->user->givePermissionTo('*');

        $this->currency = Currency::factory()->create([
            'code' => 'USD',
        ]);

        $this->company = Company::factory()->create([
            'currency_id' => $this->currency->id,
        ]);

        $this->user->companies()->attach($this->company->id);

        $partner = Partner::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $this->project = Project::factory()->create([
            'company_id'  => $this->company->id,
            'partner_id'  => $partner->id,
            'user_id'     => $this->user->id,
            'name'        => 'Test Project',
        ]);

        $this->task = Task::factory()->create([
            'company_id'  => $this->company->id,
            'project_id'  => $this->project->id,
            'title'       => 'Test Task',
        ]);
    }

    #[Test]
    public function it_lists_timesheets(): void
    {
        Timesheet::factory()->create([
            'company_id' => $this->company->id,
            'user_id'    => $this->user->id,
            'project_id' => $this->project->id,
            'task_id'    => $this->task->id,
            'date'       => now(),
            'type'       => 'projects',
        ]);

        Livewire::actingAs($this->user)
            ->test(ManageTimesheets::class)
            ->assertCanSeeTableRecords(
                Timesheet::where('company_id', $this->company->id)->get()
            );
    }

    #[Test]
    public function it_creates_a_timesheet(): void
    {
        $payload = [
            'type'       => 'projects',
            'date'       => now()->format('Y-m-d'),
            'user_id'    => $this->user->id,
            'project_id' => $this->project->id,
            'task_id'    => $this->task->id,
            'name'       => 'Work on feature',
            'unit_hours' => 4.0,
        ];

        Livewire::actingAs($this->user)
            ->test(ManageTimesheets::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        $this->assertDatabaseHas('timesheets', [
            'user_id'    => $payload['user_id'],
            'project_id' => $payload['project_id'],
            'task_id'    => $payload['task_id'],
        ]);
    }

    #[Test]
    public function it_updates_a_timesheet(): void
    {
        $timesheet = Timesheet::factory()->create([
            'company_id'  => $this->company->id,
            'user_id'     => $this->user->id,
            'project_id'  => $this->project->id,
            'task_id'     => $this->task->id,
            'date'        => now(),
            'type'        => 'projects',
            'unit_hours'  => 2.0,
        ]);

        Livewire::actingAs($this->user)
            ->test(ManageTimesheets::class)
            ->mountTableAction('edit', $timesheet)
            ->fillForm([
                'unit_hours' => 5.0,
                'name'       => 'Updated description',
            ])
            ->callMountedTableAction();

        $this->assertDatabaseHas('timesheets', [
            'id'         => $timesheet->id,
            'unit_hours' => 5.0,
        ]);
    }

    #[Test]
    public function it_deletes_a_timesheet(): void
    {
        $timesheet = Timesheet::factory()->create([
            'company_id' => $this->company->id,
            'user_id'    => $this->user->id,
            'project_id' => $this->project->id,
            'task_id'    => $this->task->id,
            'date'       => now(),
            'type'       => 'projects',
        ]);

        Livewire::actingAs($this->user)
            ->test(ManageTimesheets::class)
            ->callTableAction('delete', $timesheet);

        $this->assertDatabaseMissing('timesheets', [
            'id' => $timesheet->id,
        ]);
    }
}
