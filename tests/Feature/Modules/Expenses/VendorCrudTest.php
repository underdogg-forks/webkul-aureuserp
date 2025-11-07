<?php

namespace Tests\Feature\Modules\Expenses;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource\Pages\ListVendors;
use Modules\Expenses\Models\Partner;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class VendorCrudTest extends TestCase
{
    protected User $user;

    protected Company $company;

    protected Currency $currency;

    protected function setUp(): void
    {
        parent::setUp();

        Model::unguard();

        $this->user = User::factory()->create();

        $this->user->forceFill([
            'resource_permission' => 'global',
        ])->save();

        $this->currency = Currency::create([
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
            'currency_id' => $this->currency->id,
            'creator_id'  => $this->user->id,
        ]);

        $this->user->forceFill([
            'default_company_id' => $this->company->id,
        ])->save();
    }

    #[Test]
    public function it_lists_vendors(): void
    {
        /* Arrange */
        $vendor1 = Partner::create([
            'name'       => 'Vendor One',
            'sub_type'   => 'vendor',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $vendor2 = Partner::create([
            'name'       => 'Vendor Two',
            'sub_type'   => 'vendor',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        // Create a customer that should not appear
        $customer = Partner::create([
            'name'       => 'Customer One',
            'sub_type'   => 'customer',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListVendors::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$vendor1, $vendor2])
            ->assertCanNotSeeTableRecords([$customer]);
    }

    #[Test]
    public function it_creates_a_vendor(): void
    {
        /* Arrange */
        $payload = [
            'name'     => 'New Vendor ' . Str::random(5),
            'sub_type' => 'vendor',
            'email'    => 'vendor@example.com',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListVendors::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('partners_partners', [
            'name'     => $payload['name'],
            'sub_type' => 'vendor',
        ]);
    }

    #[Test]
    public function it_updates_a_vendor(): void
    {
        /* Arrange */
        $vendor = Partner::create([
            'name'       => 'Original Vendor',
            'sub_type'   => 'vendor',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Vendor ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListVendors::class)
            ->mountAction(TestAction::make('edit')->table($vendor), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('partners_partners', [
            'id'   => $vendor->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_vendor(): void
    {
        /* Arrange */
        $vendor = Partner::create([
            'name'       => 'Delete Me Vendor',
            'sub_type'   => 'vendor',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListVendors::class)
            ->mountAction(TestAction::make('delete')->table($vendor))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('partners_partners', [
            'id' => $vendor->id,
        ]);
    }
}
