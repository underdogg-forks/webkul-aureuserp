<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Clusters\Configurations\Resources\CalendarResource\Pages\ListCalendars;
use Modules\Core\Models\Calendar;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class CalendarCrudTest extends TestCase
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
    public function it_lists_calendars(): void
    {
        /* Arrange */
        $calendar1 = Calendar::create([
            'name' => 'Standard Week',
        ]);

        $calendar2 = Calendar::create([
            'name' => '24/7 Operations',
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListCalendars::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$calendar1, $calendar2]);
    }

    #[Test]
    public function it_creates_a_calendar(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Calendar ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListCalendars::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('hr_calendars', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_a_calendar(): void
    {
        /* Arrange */
        $calendar = Calendar::create([
            'name' => 'Original Calendar',
        ]);

        $payload = [
            'name' => 'Updated Calendar',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListCalendars::class)
            ->mountAction(TestAction::make('edit')->table($calendar), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('hr_calendars', [
            'id'   => $calendar->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_calendar(): void
    {
        /* Arrange */
        $calendar = Calendar::create([
            'name' => 'Delete Calendar',
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListCalendars::class)
            ->mountAction(TestAction::make('delete')->table($calendar))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('hr_calendars', [
            'id' => $calendar->id,
        ]);
    }
}
