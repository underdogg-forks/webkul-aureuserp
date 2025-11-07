<?php

namespace Tests\Feature\Modules\Products;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Products\Filament\Clusters\Configurations\Resources\PackageTypeResource\Pages\ListPackageTypes;
use Modules\Products\Models\PackageType;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class PackageTypeCrudTest extends TestCase
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
    public function it_lists_package_types(): void
    {
        /* Arrange */
        $packageType1 = PackageType::create([
            'name'       => 'Box',
            'length'     => 10.0,
            'width'      => 10.0,
            'height'     => 10.0,
            'company_id' => $this->company->id,
        ]);

        $packageType2 = PackageType::create([
            'name'       => 'Pallet',
            'length'     => 120.0,
            'width'      => 100.0,
            'height'     => 150.0,
            'company_id' => $this->company->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListPackageTypes::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$packageType1, $packageType2]);
    }

    #[Test]
    public function it_creates_a_package_type(): void
    {
        /* Arrange */
        $payload = [
            'name'   => 'New Package Type ' . Str::random(5),
            'length' => 20.0,
            'width'  => 15.0,
            'height' => 10.0,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPackageTypes::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('inventories_package_types', [
            'name'   => $payload['name'],
            'length' => $payload['length'],
        ]);
    }

    #[Test]
    public function it_updates_a_package_type(): void
    {
        /* Arrange */
        $packageType = PackageType::create([
            'name'       => 'Original Package',
            'length'     => 10.0,
            'width'      => 10.0,
            'height'     => 10.0,
            'company_id' => $this->company->id,
        ]);

        $payload = [
            'name' => 'Updated Package',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPackageTypes::class)
            ->mountAction(TestAction::make('edit')->table($packageType), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('inventories_package_types', [
            'id'   => $packageType->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_package_type(): void
    {
        /* Arrange */
        $packageType = PackageType::create([
            'name'       => 'Delete Package',
            'length'     => 10.0,
            'width'      => 10.0,
            'height'     => 10.0,
            'company_id' => $this->company->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPackageTypes::class)
            ->mountAction(TestAction::make('delete')->table($packageType))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('inventories_package_types', [
            'id' => $packageType->id,
        ]);
    }
}
