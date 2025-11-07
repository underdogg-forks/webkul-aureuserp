<?php

namespace Tests\Feature\Modules\Expenses;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Expenses\Enums\InvoiceStatus;
use Modules\Expenses\Enums\OrderState;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\PurchaseOrderResource\Pages\ListPurchaseOrders;
use Modules\Expenses\Models\Order as PurchaseOrder;
use Modules\Expenses\Models\Partner;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class PurchaseOrderCrudTest extends TestCase
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
            'name'       => 'Test Vendor',
            'sub_type'   => 'vendor',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);
    }

    #[Test]
    public function it_lists_purchase_orders(): void
    {
        /* Arrange */
        $purchaseOrder1 = PurchaseOrder::create([
            'name'           => 'PO0001',
            'partner_id'     => $this->partner->id,
            'company_id'     => $this->company->id,
            'currency_id'    => $this->currency->id,
            'state'          => OrderState::PURCHASE,
            'invoice_status' => InvoiceStatus::TO_INVOICE,
            'date_order'     => now(),
            'user_id'        => $this->user->id,
            'creator_id'     => $this->user->id,
        ]);

        $purchaseOrder2 = PurchaseOrder::create([
            'name'           => 'PO0002',
            'partner_id'     => $this->partner->id,
            'company_id'     => $this->company->id,
            'currency_id'    => $this->currency->id,
            'state'          => OrderState::PURCHASE,
            'invoice_status' => InvoiceStatus::TO_INVOICE,
            'date_order'     => now(),
            'user_id'        => $this->user->id,
            'creator_id'     => $this->user->id,
        ]);

        // Create a draft order that should not appear in purchase orders
        $draftOrder = PurchaseOrder::create([
            'name'           => 'PO0003',
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
            ->test(ListPurchaseOrders::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$purchaseOrder1, $purchaseOrder2])
            ->assertCanNotSeeTableRecords([$draftOrder]);
    }

    #[Test]
    public function it_creates_a_purchase_order(): void
    {
        /* Arrange */
        $payload = [
            'partner_id' => $this->partner->id,
            'date_order' => now()->format('Y-m-d'),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPurchaseOrders::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('purchases_orders', [
            'partner_id' => $payload['partner_id'],
            'state'      => OrderState::PURCHASE->value,
        ]);
    }

    #[Test]
    public function it_updates_a_purchase_order(): void
    {
        /* Arrange */
        $purchaseOrder = PurchaseOrder::create([
            'name'           => 'PO0004',
            'partner_id'     => $this->partner->id,
            'company_id'     => $this->company->id,
            'currency_id'    => $this->currency->id,
            'state'          => OrderState::PURCHASE,
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
            ->test(ListPurchaseOrders::class)
            ->mountAction(TestAction::make('edit')->table($purchaseOrder), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('purchases_orders', [
            'id'        => $purchaseOrder->id,
            'reference' => $payload['reference'],
        ]);
    }

    #[Test]
    public function it_deletes_a_purchase_order(): void
    {
        /* Arrange */
        $purchaseOrder = PurchaseOrder::create([
            'name'           => 'PO0005',
            'partner_id'     => $this->partner->id,
            'company_id'     => $this->company->id,
            'currency_id'    => $this->currency->id,
            'state'          => OrderState::PURCHASE,
            'invoice_status' => InvoiceStatus::TO_INVOICE,
            'date_order'     => now(),
            'user_id'        => $this->user->id,
            'creator_id'     => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPurchaseOrders::class)
            ->mountAction(TestAction::make('delete')->table($purchaseOrder))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('purchases_orders', [
            'id' => $purchaseOrder->id,
        ]);
    }
}
