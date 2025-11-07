<?php

namespace Tests\Feature\Modules\Crm;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Crm\Filament\Resources\TitleResource\Pages\ManageTitles;
use Modules\Crm\Models\Title;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class TitleCrudTest extends TestCase
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
    public function it_lists_titles(): void
    {
        /* Arrange */
        $visibleTitle = Title::factory()->create();
        $otherTitle   = Title::factory()->create();

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ManageTitles::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$visibleTitle])
            ->assertCanSeeTableRecords([$otherTitle]);
    }

    #[Test]
    public function it_creates_a_title(): void
    {
        /* Arrange */
        $payload = [
            'name'       => 'Title ' . Str::random(5),
            'short_name' => 'Short ' . Str::random(3),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageTitles::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('partners_titles', [
            'name'       => $payload['name'],
            'short_name' => $payload['short_name'],
        ]);
    }

    #[Test]
    public function it_updates_a_title(): void
    {
        /* Arrange */
        $title = Title::factory()->create();

        $payload = [
            'name'       => 'Updated ' . $title->name,
            'short_name' => 'Updated ' . $title->short_name,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageTitles::class)
            ->mountAction(TestAction::make('edit')->table($title), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('partners_titles', [
            'id'         => $title->id,
            'name'       => $payload['name'],
            'short_name' => $payload['short_name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_title(): void
    {
        /* Arrange */
        $title = Title::factory()->create();

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageTitles::class)
            ->mountAction(TestAction::make('delete')->table($title))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('partners_titles', [
            'id' => $title->id,
        ]);
    }
}
