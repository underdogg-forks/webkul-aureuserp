<?php

namespace Tests\Feature\Modules\Projects;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Projects\Filament\Resources\ProjectResource\Pages\ListProjects;
use Modules\Projects\Models\Project;
use Modules\Projects\Models\ProjectStage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class ProjectCrudTest extends TestCase
{
    protected User $user;

    protected ProjectStage $stage;

    protected function setUp(): void
    {
        parent::setUp();

        Model::unguard();

        $this->user = User::factory()->create();

        $this->user->forceFill([
            'resource_permission' => 'global',
        ])->save();

        $this->stage = ProjectStage::create([
            'name'        => 'Planning',
            'sort'        => 1,
            'is_active'   => true,
            'is_collapsed'=> false,
            'creator_id'  => $this->user->id,
        ]);
    }

    #[Test]
    public function it_lists_projects(): void
    {
        /* Arrange */
        $activeProject = Project::create([
            'name'       => 'Implementation',
            'stage_id'   => $this->stage->id,
            'is_active'  => true,
            'user_id'    => $this->user->id,
            'creator_id' => $this->user->id,
        ]);

        $archivedProject = Project::create([
            'name'       => 'Archived Project',
            'stage_id'   => $this->stage->id,
            'is_active'  => false,
            'user_id'    => $this->user->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListProjects::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$activeProject, $archivedProject]);
    }

    #[Test]
    public function it_creates_a_project(): void
    {
        /* Arrange */
        $payload = [
            'name'     => 'Project ' . Str::random(5),
            'stage_id' => $this->stage->id,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListProjects::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('projects_projects', [
            'name'     => $payload['name'],
            'stage_id' => $this->stage->id,
        ]);
    }

    #[Test]
    public function it_updates_a_project(): void
    {
        /* Arrange */
        $project = Project::create([
            'name'       => 'Migration',
            'stage_id'   => $this->stage->id,
            'is_active'  => true,
            'user_id'    => $this->user->id,
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated ' . $project->name,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListProjects::class)
            ->mountAction(TestAction::make('edit')->table($project), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('projects_projects', [
            'id'   => $project->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_project(): void
    {
        /* Arrange */
        $project = Project::create([
            'name'       => 'Cleanup',
            'stage_id'   => $this->stage->id,
            'is_active'  => true,
            'user_id'    => $this->user->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListProjects::class)
            ->mountAction(TestAction::make('delete')->table($project))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('projects_projects', [
            'id' => $project->id,
        ]);
    }
}
