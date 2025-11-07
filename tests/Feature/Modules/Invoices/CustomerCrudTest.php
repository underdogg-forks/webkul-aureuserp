<?php

namespace Tests\Feature\Modules\Invoices;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Invoices\Filament\Clusters\Orders\Resources\CustomerResource\Pages\ListCustomers;
use Modules\Invoices\Models\Partner;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class CustomerCrudTest extends TestCase
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
    public function it_lists_customers(): void
    {
        /* Arrange */
        $customer1 = Partner::create([
            'name'       => 'Customer One',
            'sub_type'   => 'customer',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $customer2 = Partner::create([
            'name'       => 'Customer Two',
            'sub_type'   => 'customer',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        // Create a vendor that should not appear
        $vendor = Partner::create([
            'name'       => 'Vendor One',
            'sub_type'   => 'vendor',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListCustomers::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$customer1, $customer2])
            ->assertCanNotSeeTableRecords([$vendor]);
    }

    #[Test]
    public function it_creates_a_customer(): void
    {
        /* Arrange */
        $payload = [
            'name'     => 'New Customer ' . Str::random(5),
            'sub_type' => 'customer',
            'email'    => 'customer@example.com',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListCustomers::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('partners_partners', [
            'name'     => $payload['name'],
            'sub_type' => 'customer',
        ]);
    }

    #[Test]
    public function it_updates_a_customer(): void
    {
        /* Arrange */
        $customer = Partner::create([
            'name'       => 'Original Customer',
            'sub_type'   => 'customer',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Customer ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListCustomers::class)
            ->mountAction(TestAction::make('edit')->table($customer), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('partners_partners', [
            'id'   => $customer->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_customer(): void
    {
        /* Arrange */
        $customer = Partner::create([
            'name'       => 'Delete Me Customer',
            'sub_type'   => 'customer',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListCustomers::class)
            ->mountAction(TestAction::make('delete')->table($customer))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('partners_partners', [
            'id' => $customer->id,
        ]);
    }
}
