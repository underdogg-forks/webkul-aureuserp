<?php

namespace Tests\Feature\Modules\Projects;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Crm\Models\Partner;
use Modules\Projects\Enums\TaskState;
use Modules\Projects\Filament\Resources\TaskResource\Pages\CreateTask;
use Modules\Projects\Filament\Resources\TaskResource\Pages\EditTask;
use Modules\Projects\Filament\Resources\TaskResource\Pages\ListTasks;
use Modules\Projects\Models\Project;
use Modules\Projects\Models\Task;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[Group('smoke')]
class TaskCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Company $company;

    protected Currency $currency;

    protected Project $project;

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
    }

    #[Test]
    public function it_lists_tasks(): void
    {
        Task::factory()->create([
            'company_id'  => $this->company->id,
            'project_id'  => $this->project->id,
            'title'       => 'Test Task',
            'state'       => TaskState::IN_PROGRESS,
        ]);

        Livewire::actingAs($this->user)
            ->test(ListTasks::class)
            ->assertCanSeeTableRecords(
                Task::where('company_id', $this->company->id)->get()
            );
    }

    #[Test]
    public function it_creates_a_task(): void
    {
        $payload = [
            'company_id'  => $this->company->id,
            'project_id'  => $this->project->id,
            'title'       => 'New Task',
            'state'       => TaskState::TODO->value,
        ];

        Livewire::actingAs($this->user)
            ->test(CreateTask::class)
            ->fillForm($payload)
            ->call('create');

        $this->assertDatabaseHas('projects_tasks', [
            'project_id' => $payload['project_id'],
            'title'      => 'New Task',
        ]);
    }

    #[Test]
    public function it_updates_a_task(): void
    {
        $task = Task::factory()->create([
            'company_id'  => $this->company->id,
            'project_id'  => $this->project->id,
            'title'       => 'Original Task',
            'state'       => TaskState::TODO,
        ]);

        Livewire::actingAs($this->user)
            ->test(EditTask::class, ['record' => $task->id])
            ->fillForm([
                'title' => 'Updated Task',
                'state' => TaskState::IN_PROGRESS->value,
            ])
            ->call('save');

        $this->assertDatabaseHas('projects_tasks', [
            'id'    => $task->id,
            'title' => 'Updated Task',
        ]);
    }

    #[Test]
    public function it_deletes_a_task(): void
    {
        $task = Task::factory()->create([
            'company_id' => $this->company->id,
            'project_id' => $this->project->id,
            'title'      => 'Task to Delete',
        ]);

        Livewire::actingAs($this->user)
            ->test(ListTasks::class)
            ->callTableAction('delete', $task);

        $this->assertSoftDeleted('projects_tasks', [
            'id' => $task->id,
        ]);
    }
}
