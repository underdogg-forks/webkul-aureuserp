<?php

namespace Tests\Feature\Modules\Projects;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Projects\Filament\Clusters\Configurations\Resources\MilestoneResource\Pages\ManageMilestones;
use Modules\Projects\Models\Milestone;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class MilestoneCrudTest extends TestCase
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
    public function it_lists_milestones(): void
    {
        /* Arrange */
        $milestone1 = Milestone::create([
            'name'       => 'Phase 1',
            'creator_id' => $this->user->id,
        ]);

        $milestone2 = Milestone::create([
            'name'       => 'Phase 2',
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ManageMilestones::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$milestone1, $milestone2]);
    }

    #[Test]
    public function it_creates_a_milestone(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Milestone ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageMilestones::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('projects_milestones', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_a_milestone(): void
    {
        /* Arrange */
        $milestone = Milestone::create([
            'name'       => 'Original Milestone',
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Milestone',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageMilestones::class)
            ->mountAction(TestAction::make('edit')->table($milestone), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('projects_milestones', [
            'id'   => $milestone->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_soft_deletes_a_milestone(): void
    {
        /* Arrange */
        $milestone = Milestone::create([
            'name'       => 'Delete Milestone',
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageMilestones::class)
            ->mountAction(TestAction::make('delete')->table($milestone))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('projects_milestones', [
            'id' => $milestone->id,
        ]);
    }
}
