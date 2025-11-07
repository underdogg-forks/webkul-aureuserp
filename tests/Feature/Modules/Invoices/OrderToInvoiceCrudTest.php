<?php

namespace Tests\Feature\Modules\Invoices;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Invoices\Enums\InvoiceStatus;
use Modules\Invoices\Enums\OrderState;
use Modules\Invoices\Filament\Clusters\ToInvoice\Resources\OrderToInvoiceResource\Pages\ListOrderToInvoices;
use Modules\Invoices\Models\Order;
use Modules\Invoices\Models\Partner;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[Group('smoke')]
class OrderToInvoiceCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Company $company;

    protected Currency $currency;

    protected Partner $partner;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->user->givePermissionTo('*');

        $this->currency = Currency::factory()->create([
            'code' => 'USD',
        ]);

        $this->company = Company::factory()->create([
            'currency_id' => $this->currency->id,
        ]);

        $this->user->companies()->attach($this->company->id);

        $this->partner = Partner::factory()->create([
            'company_id' => $this->company->id,
            'name'       => 'Test Customer',
            'sub_type'   => 'customer',
        ]);
    }

    #[Test]
    public function it_lists_orders_to_invoice(): void
    {
        // Create an order with TO_INVOICE status
        Order::factory()->create([
            'company_id'     => $this->company->id,
            'partner_id'     => $this->partner->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::TO_INVOICE,
            'name'           => 'SO0001',
        ]);

        // Create an order that should NOT appear (not TO_INVOICE)
        Order::factory()->create([
            'company_id'     => $this->company->id,
            'partner_id'     => $this->partner->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::INVOICED,
            'name'           => 'SO0002',
        ]);

        Livewire::actingAs($this->user)
            ->test(ListOrderToInvoices::class)
            ->assertCanSeeTableRecords(
                Order::where('company_id', $this->company->id)
                    ->where('invoice_status', InvoiceStatus::TO_INVOICE)
                    ->get()
            )
            ->assertCanNotSeeTableRecords(
                Order::where('company_id', $this->company->id)
                    ->where('invoice_status', '!=', InvoiceStatus::TO_INVOICE)
                    ->get()
            );
    }

    #[Test]
    public function it_shows_only_orders_needing_invoicing(): void
    {
        // Create orders with different invoice statuses
        $toInvoiceOrder = Order::factory()->create([
            'company_id'     => $this->company->id,
            'partner_id'     => $this->partner->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::TO_INVOICE,
        ]);

        $invoicedOrder = Order::factory()->create([
            'company_id'     => $this->company->id,
            'partner_id'     => $this->partner->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::INVOICED,
        ]);

        $upsellOrder = Order::factory()->create([
            'company_id'     => $this->company->id,
            'partner_id'     => $this->partner->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::UPSELLING,
        ]);

        Livewire::actingAs($this->user)
            ->test(ListOrderToInvoices::class)
            ->assertCanSeeTableRecords([$toInvoiceOrder])
            ->assertCanNotSeeTableRecords([$invoicedOrder, $upsellOrder]);
    }

    #[Test]
    public function it_counts_only_to_invoice_orders(): void
    {
        // Create multiple orders with different statuses
        Order::factory()->count(3)->create([
            'company_id'     => $this->company->id,
            'partner_id'     => $this->partner->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::TO_INVOICE,
        ]);

        Order::factory()->count(2)->create([
            'company_id'     => $this->company->id,
            'partner_id'     => $this->partner->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::INVOICED,
        ]);

        $component = Livewire::actingAs($this->user)
            ->test(ListOrderToInvoices::class);

        // Should see only 3 records (TO_INVOICE status)
        $this->assertEquals(
            3,
            Order::where('company_id', $this->company->id)
                ->where('invoice_status', InvoiceStatus::TO_INVOICE)
                ->count()
        );
    }
}
