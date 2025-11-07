<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Enums\RoundingMethod;
use Modules\Core\Filament\Resources\CashRoundingResource\Pages\ListCashRounding;
use Modules\Core\Models\CashRounding;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class CashRoundingCrudTest extends TestCase
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
    public function it_lists_cash_roundings(): void
    {
        /* Arrange */
        $rounding1 = CashRounding::create([
            'name'            => '0.05 Rounding',
            'rounding'        => 0.05,
            'rounding_method' => RoundingMethod::ADD_INVOICE_LINE,
        ]);

        $rounding2 = CashRounding::create([
            'name'            => '0.10 Rounding',
            'rounding'        => 0.10,
            'rounding_method' => RoundingMethod::ADD_INVOICE_LINE,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListCashRounding::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$rounding1, $rounding2]);
    }

    #[Test]
    public function it_creates_a_cash_rounding(): void
    {
        /* Arrange */
        $payload = [
            'name'            => 'New Rounding ' . Str::random(5),
            'rounding'        => 0.25,
            'rounding_method' => RoundingMethod::ADD_INVOICE_LINE->value,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListCashRounding::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_cash_roundings', [
            'name'     => $payload['name'],
            'rounding' => $payload['rounding'],
        ]);
    }

    #[Test]
    public function it_updates_a_cash_rounding(): void
    {
        /* Arrange */
        $rounding = CashRounding::create([
            'name'            => 'Original Rounding',
            'rounding'        => 0.05,
            'rounding_method' => RoundingMethod::ADD_INVOICE_LINE,
        ]);

        $payload = [
            'name' => 'Updated Rounding',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListCashRounding::class)
            ->mountAction(TestAction::make('edit')->table($rounding), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_cash_roundings', [
            'id'   => $rounding->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_cash_rounding(): void
    {
        /* Arrange */
        $rounding = CashRounding::create([
            'name'            => 'Delete Rounding',
            'rounding'        => 0.05,
            'rounding_method' => RoundingMethod::ADD_INVOICE_LINE,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListCashRounding::class)
            ->mountAction(TestAction::make('delete')->table($rounding))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('accounts_cash_roundings', [
            'id' => $rounding->id,
        ]);
    }
}
