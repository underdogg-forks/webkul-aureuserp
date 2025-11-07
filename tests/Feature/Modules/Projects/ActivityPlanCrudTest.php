<?php

namespace Tests\Feature\Modules\Projects;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Projects\Filament\Clusters\Configurations\Resources\ActivityPlanResource\Pages\ListActivityPlans;
use Modules\Projects\Models\ActivityPlan;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class ActivityPlanCrudTest extends TestCase
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
    public function it_lists_activity_plans(): void
    {
        /* Arrange */
        $activityPlan1 = ActivityPlan::create([
            'name'       => 'Project Kickoff',
            'creator_id' => $this->user->id,
        ]);

        $activityPlan2 = ActivityPlan::create([
            'name'       => 'Sprint Planning',
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListActivityPlans::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$activityPlan1, $activityPlan2]);
    }

    #[Test]
    public function it_creates_an_activity_plan(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Activity Plan ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListActivityPlans::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('projects_activity_plans', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_an_activity_plan(): void
    {
        /* Arrange */
        $activityPlan = ActivityPlan::create([
            'name'       => 'Original Activity Plan',
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Activity Plan',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListActivityPlans::class)
            ->mountAction(TestAction::make('edit')->table($activityPlan), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('projects_activity_plans', [
            'id'   => $activityPlan->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_soft_deletes_an_activity_plan(): void
    {
        /* Arrange */
        $activityPlan = ActivityPlan::create([
            'name'       => 'Delete Activity Plan',
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListActivityPlans::class)
            ->mountAction(TestAction::make('delete')->table($activityPlan))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('projects_activity_plans', [
            'id' => $activityPlan->id,
        ]);
    }
}
