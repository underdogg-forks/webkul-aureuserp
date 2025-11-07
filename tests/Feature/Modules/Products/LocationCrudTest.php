<?php

namespace Tests\Feature\Modules\Products;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Products\Enums\LocationType;
use Modules\Products\Filament\Clusters\Configurations\Resources\LocationResource\Pages\ListLocations;
use Modules\Products\Models\Location;
use Modules\Products\Models\Warehouse;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class LocationCrudTest extends TestCase
{
    protected User $user;

    protected Company $company;

    protected Warehouse $warehouse;

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

        $this->warehouse = Warehouse::create([
            'name'       => 'Main Warehouse',
            'code'       => 'WH01',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);
    }

    #[Test]
    public function it_lists_locations(): void
    {
        /* Arrange */
        $location1 = Location::create([
            'name'         => 'Shelf A',
            'full_name'    => 'Main Warehouse/Shelf A',
            'type'         => LocationType::INTERNAL,
            'warehouse_id' => $this->warehouse->id,
            'company_id'   => $this->company->id,
            'creator_id'   => $this->user->id,
        ]);

        $location2 = Location::create([
            'name'         => 'Shelf B',
            'full_name'    => 'Main Warehouse/Shelf B',
            'type'         => LocationType::INTERNAL,
            'warehouse_id' => $this->warehouse->id,
            'company_id'   => $this->company->id,
            'creator_id'   => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListLocations::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$location1, $location2]);
    }

    #[Test]
    public function it_creates_a_location(): void
    {
        /* Arrange */
        $payload = [
            'name'         => 'New Location ' . Str::random(5),
            'type'         => LocationType::INTERNAL->value,
            'warehouse_id' => $this->warehouse->id,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListLocations::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('inventories_locations', [
            'name'         => $payload['name'],
            'type'         => $payload['type'],
            'warehouse_id' => $this->warehouse->id,
        ]);
    }

    #[Test]
    public function it_updates_a_location(): void
    {
        /* Arrange */
        $location = Location::create([
            'name'         => 'Original Location',
            'full_name'    => 'Main Warehouse/Original Location',
            'type'         => LocationType::INTERNAL,
            'warehouse_id' => $this->warehouse->id,
            'company_id'   => $this->company->id,
            'creator_id'   => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Location',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListLocations::class)
            ->mountAction(TestAction::make('edit')->table($location), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('inventories_locations', [
            'id'   => $location->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_soft_deletes_a_location(): void
    {
        /* Arrange */
        $location = Location::create([
            'name'         => 'Delete Location',
            'full_name'    => 'Main Warehouse/Delete Location',
            'type'         => LocationType::INTERNAL,
            'warehouse_id' => $this->warehouse->id,
            'company_id'   => $this->company->id,
            'creator_id'   => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListLocations::class)
            ->mountAction(TestAction::make('delete')->table($location))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('inventories_locations', [
            'id' => $location->id,
        ]);
    }
}
