<?php

namespace Tests\Feature\Modules\Products;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Products\Filament\Clusters\Configurations\Resources\WarehouseResource\Pages\ListWarehouses;
use Modules\Products\Models\Warehouse;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class WarehouseCrudTest extends TestCase
{
    protected User $user;

    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();

        Model::unguard();

        $this->user = User::factory()->create();

        $this->user->forceFill([
            'resource_permission' => 'global',
        ])->save();

        $currency = Currency::create([
            'name'           => 'USD',
            'symbol'         => '$',
            'iso_numeric'    => 840,
            'decimal_places' => 2,
            'full_name'      => 'US Dollar',
            'rounding'       => 0.00,
            'active'         => true,
        ]);

        $this->company = Company::create([
            'name'        => 'Acme Corp',
            'company_id'  => (string) Str::uuid(),
            'email'       => 'info@example.com',
            'currency_id' => $currency->id,
            'creator_id'  => $this->user->id,
        ]);

        $this->user->forceFill([
            'default_company_id' => $this->company->id,
        ])->save();
    }

    #[Test]
    public function it_lists_warehouses(): void
    {
        /* Arrange */
        $warehouse1 = Warehouse::create([
            'name'       => 'Main Warehouse',
            'code'       => 'WH01',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $warehouse2 = Warehouse::create([
            'name'       => 'Secondary Warehouse',
            'code'       => 'WH02',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListWarehouses::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$warehouse1, $warehouse2]);
    }

    #[Test]
    public function it_creates_a_warehouse(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Warehouse ' . Str::random(5),
            'code' => 'WH' . Str::random(3),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListWarehouses::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('inventories_warehouses', [
            'name' => $payload['name'],
            'code' => $payload['code'],
        ]);
    }

    #[Test]
    public function it_updates_a_warehouse(): void
    {
        /* Arrange */
        $warehouse = Warehouse::create([
            'name'       => 'Original Warehouse',
            'code'       => 'WHO',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Warehouse',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListWarehouses::class)
            ->mountAction(TestAction::make('edit')->table($warehouse), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('inventories_warehouses', [
            'id'   => $warehouse->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_soft_deletes_a_warehouse(): void
    {
        /* Arrange */
        $warehouse = Warehouse::create([
            'name'       => 'Delete Warehouse',
            'code'       => 'WHD',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListWarehouses::class)
            ->mountAction(TestAction::make('delete')->table($warehouse))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('inventories_warehouses', [
            'id' => $warehouse->id,
        ]);
    }
}
