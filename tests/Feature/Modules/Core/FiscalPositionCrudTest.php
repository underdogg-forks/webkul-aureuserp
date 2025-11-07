<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\FiscalPositionResource\Pages\ListFiscalPositions;
use Modules\Core\Models\FiscalPosition;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class FiscalPositionCrudTest extends TestCase
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
    public function it_lists_fiscal_positions(): void
    {
        /* Arrange */
        $position1 = FiscalPosition::create([
            'name' => 'Domestic',
        ]);

        $position2 = FiscalPosition::create([
            'name' => 'International',
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListFiscalPositions::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$position1, $position2]);
    }

    #[Test]
    public function it_creates_a_fiscal_position(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Fiscal Position ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListFiscalPositions::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_fiscal_positions', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_a_fiscal_position(): void
    {
        /* Arrange */
        $position = FiscalPosition::create([
            'name' => 'Original Position',
        ]);

        $payload = [
            'name' => 'Updated Position',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListFiscalPositions::class)
            ->mountAction(TestAction::make('edit')->table($position), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_fiscal_positions', [
            'id'   => $position->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_fiscal_position(): void
    {
        /* Arrange */
        $position = FiscalPosition::create([
            'name' => 'Delete Position',
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListFiscalPositions::class)
            ->mountAction(TestAction::make('delete')->table($position))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('accounts_fiscal_positions', [
            'id' => $position->id,
        ]);
    }
}
