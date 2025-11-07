<?php

namespace Tests\Feature\Modules\Projects;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Projects\Filament\Clusters\Configurations\Resources\TaskStageResource\Pages\ManageTaskStages;
use Modules\Projects\Models\TaskStage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class TaskStageCrudTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        Model::unguard();

        $this->user = User::factory()->create();

        $this->user->forceFill([
            'resource_permission' => 'global',
        ])->save();
    }

    #[Test]
    public function it_lists_task_stages(): void
    {
        /* Arrange */
        $stage1 = TaskStage::create([
            'name'       => 'To Do',
            'sort'       => 1,
            'creator_id' => $this->user->id,
        ]);

        $stage2 = TaskStage::create([
            'name'       => 'In Progress',
            'sort'       => 2,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ManageTaskStages::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$stage1, $stage2]);
    }

    #[Test]
    public function it_creates_a_task_stage(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Task Stage ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageTaskStages::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('projects_task_stages', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_a_task_stage(): void
    {
        /* Arrange */
        $stage = TaskStage::create([
            'name'       => 'Original Task Stage',
            'sort'       => 1,
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Task Stage',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageTaskStages::class)
            ->mountAction(TestAction::make('edit')->table($stage), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('projects_task_stages', [
            'id'   => $stage->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_soft_deletes_a_task_stage(): void
    {
        /* Arrange */
        $stage = TaskStage::create([
            'name'       => 'Delete Task Stage',
            'sort'       => 1,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageTaskStages::class)
            ->mountAction(TestAction::make('delete')->table($stage))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('projects_task_stages', [
            'id' => $stage->id,
        ]);
    }
}
