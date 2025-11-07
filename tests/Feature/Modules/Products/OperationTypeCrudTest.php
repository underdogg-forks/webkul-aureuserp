<?php

namespace Tests\Feature\Modules\Products;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Products\Enums\OperationType as OperationTypeEnum;
use Modules\Products\Filament\Clusters\Configurations\Resources\OperationTypeResource\Pages\ListOperationTypes;
use Modules\Products\Models\Location;
use Modules\Products\Models\OperationType;
use Modules\Products\Models\Warehouse;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class OperationTypeCrudTest extends TestCase
{
    protected User $user;

    protected Company $company;

    protected Warehouse $warehouse;

    protected Location $sourceLocation;

    protected Location $destinationLocation;

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

        $this->sourceLocation = Location::create([
            'name'         => 'Stock',
            'full_name'    => 'WH/Stock',
            'type'         => 'internal',
            'warehouse_id' => $this->warehouse->id,
            'company_id'   => $this->company->id,
            'creator_id'   => $this->user->id,
        ]);

        $this->destinationLocation = Location::create([
            'name'         => 'Output',
            'full_name'    => 'WH/Output',
            'type'         => 'internal',
            'warehouse_id' => $this->warehouse->id,
            'company_id'   => $this->company->id,
            'creator_id'   => $this->user->id,
        ]);
    }

    #[Test]
    public function it_lists_operation_types(): void
    {
        /* Arrange */
        $operationType1 = OperationType::create([
            'name'                     => 'Receipts',
            'type'                     => OperationTypeEnum::INCOMING,
            'warehouse_id'             => $this->warehouse->id,
            'source_location_id'       => $this->sourceLocation->id,
            'destination_location_id'  => $this->destinationLocation->id,
            'company_id'               => $this->company->id,
            'creator_id'               => $this->user->id,
        ]);

        $operationType2 = OperationType::create([
            'name'                     => 'Delivery Orders',
            'type'                     => OperationTypeEnum::OUTGOING,
            'warehouse_id'             => $this->warehouse->id,
            'source_location_id'       => $this->sourceLocation->id,
            'destination_location_id'  => $this->destinationLocation->id,
            'company_id'               => $this->company->id,
            'creator_id'               => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListOperationTypes::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$operationType1, $operationType2]);
    }

    #[Test]
    public function it_creates_an_operation_type(): void
    {
        /* Arrange */
        $payload = [
            'name'                    => 'New Operation Type ' . Str::random(5),
            'type'                    => OperationTypeEnum::INTERNAL->value,
            'warehouse_id'            => $this->warehouse->id,
            'source_location_id'      => $this->sourceLocation->id,
            'destination_location_id' => $this->destinationLocation->id,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListOperationTypes::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('inventories_operation_types', [
            'name' => $payload['name'],
            'type' => $payload['type'],
        ]);
    }

    #[Test]
    public function it_updates_an_operation_type(): void
    {
        /* Arrange */
        $operationType = OperationType::create([
            'name'                     => 'Original Operation Type',
            'type'                     => OperationTypeEnum::INCOMING,
            'warehouse_id'             => $this->warehouse->id,
            'source_location_id'       => $this->sourceLocation->id,
            'destination_location_id'  => $this->destinationLocation->id,
            'company_id'               => $this->company->id,
            'creator_id'               => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Operation Type',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListOperationTypes::class)
            ->mountAction(TestAction::make('edit')->table($operationType), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('inventories_operation_types', [
            'id'   => $operationType->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_soft_deletes_an_operation_type(): void
    {
        /* Arrange */
        $operationType = OperationType::create([
            'name'                     => 'Delete Operation Type',
            'type'                     => OperationTypeEnum::INCOMING,
            'warehouse_id'             => $this->warehouse->id,
            'source_location_id'       => $this->sourceLocation->id,
            'destination_location_id'  => $this->destinationLocation->id,
            'company_id'               => $this->company->id,
            'creator_id'               => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListOperationTypes::class)
            ->mountAction(TestAction::make('delete')->table($operationType))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('inventories_operation_types', [
            'id' => $operationType->id,
        ]);
    }
}
