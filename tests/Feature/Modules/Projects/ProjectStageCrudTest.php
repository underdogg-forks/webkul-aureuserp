<?php

namespace Tests\Feature\Modules\Projects;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Projects\Filament\Clusters\Configurations\Resources\ProjectStageResource\Pages\ManageProjectStages;
use Modules\Projects\Models\ProjectStage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class ProjectStageCrudTest extends TestCase
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
    public function it_lists_project_stages(): void
    {
        /* Arrange */
        $stage1 = ProjectStage::create([
            'name'       => 'Planning',
            'sort'       => 1,
            'creator_id' => $this->user->id,
        ]);

        $stage2 = ProjectStage::create([
            'name'       => 'Execution',
            'sort'       => 2,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ManageProjectStages::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$stage1, $stage2]);
    }

    #[Test]
    public function it_creates_a_project_stage(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Stage ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageProjectStages::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('projects_project_stages', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_a_project_stage(): void
    {
        /* Arrange */
        $stage = ProjectStage::create([
            'name'       => 'Original Stage',
            'sort'       => 1,
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Stage',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageProjectStages::class)
            ->mountAction(TestAction::make('edit')->table($stage), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('projects_project_stages', [
            'id'   => $stage->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_soft_deletes_a_project_stage(): void
    {
        /* Arrange */
        $stage = ProjectStage::create([
            'name'       => 'Delete Stage',
            'sort'       => 1,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageProjectStages::class)
            ->mountAction(TestAction::make('delete')->table($stage))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('projects_project_stages', [
            'id' => $stage->id,
        ]);
    }
}
