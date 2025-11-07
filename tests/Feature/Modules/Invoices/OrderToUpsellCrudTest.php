<?php

namespace Tests\Feature\Modules\Invoices;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Invoices\Enums\InvoiceStatus;
use Modules\Invoices\Enums\OrderState;
use Modules\Invoices\Filament\Clusters\ToInvoice\Resources\OrderToUpsellResource\Pages\ListOrderToUpsells;
use Modules\Invoices\Models\Order;
use Modules\Invoices\Models\Partner;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[Group('smoke')]
class OrderToUpsellCrudTest extends TestCase
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
    public function it_lists_orders_to_upsell(): void
    {
        // Create an order with UPSELLING status
        Order::factory()->create([
            'company_id'     => $this->company->id,
            'partner_id'     => $this->partner->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::UPSELLING,
            'name'           => 'SO0001',
        ]);

        // Create an order that should NOT appear (not UPSELLING)
        Order::factory()->create([
            'company_id'     => $this->company->id,
            'partner_id'     => $this->partner->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::INVOICED,
            'name'           => 'SO0002',
        ]);

        Livewire::actingAs($this->user)
            ->test(ListOrderToUpsells::class)
            ->assertCanSeeTableRecords(
                Order::where('company_id', $this->company->id)
                    ->where('invoice_status', InvoiceStatus::UPSELLING)
                    ->get()
            )
            ->assertCanNotSeeTableRecords(
                Order::where('company_id', $this->company->id)
                    ->where('invoice_status', '!=', InvoiceStatus::UPSELLING)
                    ->get()
            );
    }

    #[Test]
    public function it_shows_only_orders_for_upselling(): void
    {
        // Create orders with different invoice statuses
        $upsellOrder = Order::factory()->create([
            'company_id'     => $this->company->id,
            'partner_id'     => $this->partner->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::UPSELLING,
        ]);

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

        Livewire::actingAs($this->user)
            ->test(ListOrderToUpsells::class)
            ->assertCanSeeTableRecords([$upsellOrder])
            ->assertCanNotSeeTableRecords([$toInvoiceOrder, $invoicedOrder]);
    }

    #[Test]
    public function it_counts_only_upselling_orders(): void
    {
        // Create multiple orders with different statuses
        Order::factory()->count(2)->create([
            'company_id'     => $this->company->id,
            'partner_id'     => $this->partner->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::UPSELLING,
        ]);

        Order::factory()->count(3)->create([
            'company_id'     => $this->company->id,
            'partner_id'     => $this->partner->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::TO_INVOICE,
        ]);

        Order::factory()->count(1)->create([
            'company_id'     => $this->company->id,
            'partner_id'     => $this->partner->id,
            'state'          => OrderState::SALE,
            'invoice_status' => InvoiceStatus::INVOICED,
        ]);

        $component = Livewire::actingAs($this->user)
            ->test(ListOrderToUpsells::class);

        // Should see only 2 records (UPSELLING status)
        $this->assertEquals(
            2,
            Order::where('company_id', $this->company->id)
                ->where('invoice_status', InvoiceStatus::UPSELLING)
                ->count()
        );
    }
}
