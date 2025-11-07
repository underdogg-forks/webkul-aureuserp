<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Clusters\Configurations\Resources\ActivityTypeResource\Pages\ListActivityTypes;
use Modules\Core\Models\ActivityType;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class ActivityTypeCrudTest extends TestCase
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
    public function it_lists_activity_types(): void
    {
        /* Arrange */
        $activityType1 = ActivityType::create([
            'name' => 'Email',
        ]);

        $activityType2 = ActivityType::create([
            'name' => 'Call',
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListActivityTypes::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$activityType1, $activityType2]);
    }

    #[Test]
    public function it_creates_an_activity_type(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Activity Type ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListActivityTypes::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('crm_activity_types', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_an_activity_type(): void
    {
        /* Arrange */
        $activityType = ActivityType::create([
            'name' => 'Original Activity Type',
        ]);

        $payload = [
            'name' => 'Updated Activity Type',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListActivityTypes::class)
            ->mountAction(TestAction::make('edit')->table($activityType), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('crm_activity_types', [
            'id'   => $activityType->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_an_activity_type(): void
    {
        /* Arrange */
        $activityType = ActivityType::create([
            'name' => 'Delete Activity Type',
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListActivityTypes::class)
            ->mountAction(TestAction::make('delete')->table($activityType))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('crm_activity_types', [
            'id' => $activityType->id,
        ]);
    }
}
