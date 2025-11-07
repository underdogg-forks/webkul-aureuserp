<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Enums\TypeTaxUse;
use Modules\Core\Enums\AmountType;
use Modules\Core\Filament\Resources\TaxResource\Pages\ListTaxes;
use Modules\Core\Models\Tax;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class TaxCrudTest extends TestCase
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
    public function it_lists_taxes(): void
    {
        /* Arrange */
        $tax1 = Tax::create([
            'name'         => 'VAT 20%',
            'amount'       => 20.0,
            'type_tax_use' => TypeTaxUse::SALE,
            'amount_type'  => AmountType::PERCENT,
            'is_active'    => true,
        ]);

        $tax2 = Tax::create([
            'name'         => 'Sales Tax 10%',
            'amount'       => 10.0,
            'type_tax_use' => TypeTaxUse::SALE,
            'amount_type'  => AmountType::PERCENT,
            'is_active'    => true,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListTaxes::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$tax1, $tax2]);
    }

    #[Test]
    public function it_creates_a_tax(): void
    {
        /* Arrange */
        $payload = [
            'name'         => 'New Tax ' . Str::random(5),
            'amount'       => 15.0,
            'type_tax_use' => TypeTaxUse::SALE->value,
            'amount_type'  => AmountType::PERCENT->value,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListTaxes::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_taxes', [
            'name'   => $payload['name'],
            'amount' => $payload['amount'],
        ]);
    }

    #[Test]
    public function it_updates_a_tax(): void
    {
        /* Arrange */
        $tax = Tax::create([
            'name'         => 'Original Tax',
            'amount'       => 20.0,
            'type_tax_use' => TypeTaxUse::SALE,
            'amount_type'  => AmountType::PERCENT,
            'is_active'    => true,
        ]);

        $payload = [
            'name' => 'Updated Tax',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListTaxes::class)
            ->mountAction(TestAction::make('edit')->table($tax), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_taxes', [
            'id'   => $tax->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_tax(): void
    {
        /* Arrange */
        $tax = Tax::create([
            'name'         => 'Delete Tax',
            'amount'       => 20.0,
            'type_tax_use' => TypeTaxUse::SALE,
            'amount_type'  => AmountType::PERCENT,
            'is_active'    => true,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListTaxes::class)
            ->mountAction(TestAction::make('delete')->table($tax))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('accounts_taxes', [
            'id' => $tax->id,
        ]);
    }
}
