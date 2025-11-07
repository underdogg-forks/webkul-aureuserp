<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\TeamResource\Pages\ManageTeams;
use Modules\Core\Models\Team;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class TeamCrudTest extends TestCase
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
    public function it_lists_teams(): void
    {
        /* Arrange */
        $team1 = Team::create([
            'name' => 'Sales Team',
        ]);

        $team2 = Team::create([
            'name' => 'Development Team',
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ManageTeams::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$team1, $team2]);
    }

    #[Test]
    public function it_creates_a_team(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Team ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageTeams::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('teams', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_a_team(): void
    {
        /* Arrange */
        $team = Team::create([
            'name' => 'Original Team Name',
        ]);

        $payload = [
            'name' => 'Updated Team Name ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageTeams::class)
            ->mountAction(TestAction::make('edit')->table($team), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('teams', [
            'id'   => $team->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_team(): void
    {
        /* Arrange */
        $team = Team::create([
            'name' => 'Delete Me Team',
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageTeams::class)
            ->mountAction(TestAction::make('delete')->table($team))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('teams', [
            'id' => $team->id,
        ]);
    }
}
