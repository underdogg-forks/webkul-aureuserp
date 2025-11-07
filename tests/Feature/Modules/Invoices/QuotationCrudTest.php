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
use Modules\Invoices\Filament\Clusters\Orders\Resources\QuotationResource\Pages\ListQuotations;
use Modules\Invoices\Models\Order;
use Modules\Invoices\Models\Partner;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class QuotationCrudTest extends TestCase
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
    public function it_lists_quotations(): void
    {
        /* Arrange */
        $quotation1 = Order::create([
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

        $quotation2 = Order::create([
            'name'           => 'Q0002',
            'partner_id'     => $this->partner->id,
            'company_id'     => $this->company->id,
            'currency_id'    => $this->currency->id,
            'state'          => OrderState::SENT,
            'invoice_status' => InvoiceStatus::NO,
            'date_order'     => now(),
            'user_id'        => $this->user->id,
            'creator_id'     => $this->user->id,
        ]);

        // Create a confirmed sale order that should appear in a different tab
        $saleOrder = Order::create([
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

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListQuotations::class);

        /* Assert */
        // Both draft and sent quotations should be visible in the default view
        $component->assertCanSeeTableRecords([$quotation1, $quotation2]);
    }

    #[Test]
    public function it_creates_a_quotation(): void
    {
        /* Arrange */
        $payload = [
            'partner_id' => $this->partner->id,
            'date_order' => now()->format('Y-m-d'),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListQuotations::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('sales_orders', [
            'partner_id' => $payload['partner_id'],
            'state'      => OrderState::DRAFT->value,
        ]);
    }

    #[Test]
    public function it_updates_a_quotation(): void
    {
        /* Arrange */
        $quotation = Order::create([
            'name'           => 'Q0003',
            'partner_id'     => $this->partner->id,
            'company_id'     => $this->company->id,
            'currency_id'    => $this->currency->id,
            'state'          => OrderState::DRAFT,
            'invoice_status' => InvoiceStatus::NO,
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
            ->test(ListQuotations::class)
            ->mountAction(TestAction::make('edit')->table($quotation), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('sales_orders', [
            'id'        => $quotation->id,
            'reference' => $payload['reference'],
        ]);
    }

    #[Test]
    public function it_deletes_a_quotation(): void
    {
        /* Arrange */
        $quotation = Order::create([
            'name'           => 'Q0004',
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
        Livewire::actingAs($this->user)
            ->test(ListQuotations::class)
            ->mountAction(TestAction::make('delete')->table($quotation))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('sales_orders', [
            'id' => $quotation->id,
        ]);
    }
}
