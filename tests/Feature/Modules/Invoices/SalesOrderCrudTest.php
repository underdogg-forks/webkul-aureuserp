<?php

namespace Tests\Feature\Modules\Invoices;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Invoices\Enums\InvoiceStatus;
use Modules\Invoices\Enums\OrderState;
use Modules\Invoices\Filament\Clusters\Orders\Resources\OrderResource\Pages\ListOrders;
use Modules\Invoices\Models\Order;
use Modules\Invoices\Models\Partner;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class SalesOrderCrudTest extends TestCase
{
    protected User $user;

    protected Company $company;

    protected Currency $currency;

    protected Partner $partner;

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

        $this->partner = Partner::create([
            'name'       => 'Test Customer',
            'sub_type'   => 'customer',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);
    }

    #[Test]
    public function it_lists_sales_orders(): void
    {
        /* Arrange */
        $salesOrder1 = Order::create([
            'name'           => 'SO0001',
            'partner_id'     => $this->partner->id,
            'company_id'     => $this->company->id,
            'currency_id'    => $this->currency->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::TO_INVOICE,
            'date_order'     => now(),
            'user_id'        => $this->user->id,
            'creator_id'     => $this->user->id,
        ]);

        $salesOrder2 = Order::create([
            'name'           => 'SO0002',
            'partner_id'     => $this->partner->id,
            'company_id'     => $this->company->id,
            'currency_id'    => $this->currency->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::TO_INVOICE,
            'date_order'     => now(),
            'user_id'        => $this->user->id,
            'creator_id'     => $this->user->id,
        ]);

        // Create a quotation that should not appear in sales orders
        $quotation = Order::create([
            'name'           => 'Q0001',
            'partner_id'     => $this->partner->id,
            'company_id'     => $this->company->id,
            'currency_id'    => $this->currency->id,
            'state'          => OrderState::DRAFT,
            'invoice_status' => InvoiceStatus::NO,
            'date_order'     => now(),
            'user_id'        => $this->user->id,
            'creator_id'     => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListOrders::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$salesOrder1, $salesOrder2])
            ->assertCanNotSeeTableRecords([$quotation]);
    }

    #[Test]
    public function it_creates_a_sales_order(): void
    {
        /* Arrange */
        $payload = [
            'partner_id' => $this->partner->id,
            'date_order' => now()->format('Y-m-d'),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListOrders::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('sales_orders', [
            'partner_id' => $payload['partner_id'],
            'state'      => OrderState::SALE->value,
        ]);
    }

    #[Test]
    public function it_updates_a_sales_order(): void
    {
        /* Arrange */
        $salesOrder = Order::create([
            'name'           => 'SO0003',
            'partner_id'     => $this->partner->id,
            'company_id'     => $this->company->id,
            'currency_id'    => $this->currency->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::TO_INVOICE,
            'date_order'     => now(),
            'user_id'        => $this->user->id,
            'creator_id'     => $this->user->id,
            'reference'      => 'Original Ref',
        ]);

        $payload = [
            'reference' => 'Updated Ref ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListOrders::class)
            ->mountAction(TestAction::make('edit')->table($salesOrder), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('sales_orders', [
            'id'        => $salesOrder->id,
            'reference' => $payload['reference'],
        ]);
    }

    #[Test]
    public function it_deletes_a_sales_order(): void
    {
        /* Arrange */
        $salesOrder = Order::create([
            'name'           => 'SO0004',
            'partner_id'     => $this->partner->id,
            'company_id'     => $this->company->id,
            'currency_id'    => $this->currency->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::TO_INVOICE,
            'date_order'     => now(),
            'user_id'        => $this->user->id,
            'creator_id'     => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListOrders::class)
            ->mountAction(TestAction::make('delete')->table($salesOrder))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('sales_orders', [
            'id' => $salesOrder->id,
        ]);
    }
}
