<?php

namespace Tests\Feature\Modules\Expenses;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Expenses\Enums\OrderState;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Pages\ListOrders;
use Modules\Expenses\Models\Order;
use Modules\Expenses\Models\Partner;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class ExpensesOrderCrudTest extends TestCase
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
        $purchaseOrder = Order::create([
            'name'        => 'PO001',
            'partner_id'  => $this->partner->id,
            'company_id'  => $this->company->id,
            'state'       => OrderState::PURCHASE,
            'date_order'  => now(),
            'user_id'     => $this->user->id,
            'creator_id'  => $this->user->id,
        ]);

        // Create a draft order to verify filtering
        $draftOrder = Order::create([
            'name'        => 'PO002-DRAFT',
            'partner_id'  => $this->partner->id,
            'company_id'  => $this->company->id,
            'state'       => OrderState::DRAFT,
            'date_order'  => now(),
            'user_id'     => $this->user->id,
            'creator_id'  => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListOrders::class);

        /* Assert - Purchase order should be visible, draft should also be visible in all orders */
        $component->assertCanSeeTableRecords([$purchaseOrder, $draftOrder]);
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
            ->test(ListOrders::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('purchases_orders', [
            'partner_id' => $payload['partner_id'],
        ]);
    }

    #[Test]
    public function it_updates_a_purchase_order(): void
    {
        /* Arrange */
        $order = Order::create([
            'name'        => 'PO003',
            'partner_id'  => $this->partner->id,
            'company_id'  => $this->company->id,
            'state'       => OrderState::DRAFT,
            'date_order'  => now(),
            'user_id'     => $this->user->id,
            'creator_id'  => $this->user->id,
            'notes'       => 'Original Notes',
        ]);

        $payload = [
            'notes' => 'Updated Notes ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListOrders::class)
            ->mountAction(TestAction::make('edit')->table($order), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('purchases_orders', [
            'id'    => $order->id,
            'notes' => $payload['notes'],
        ]);
    }

    #[Test]
    public function it_deletes_a_purchase_order(): void
    {
        /* Arrange */
        $order = Order::create([
            'name'        => 'PO004',
            'partner_id'  => $this->partner->id,
            'company_id'  => $this->company->id,
            'state'       => OrderState::DRAFT,
            'date_order'  => now(),
            'user_id'     => $this->user->id,
            'creator_id'  => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListOrders::class)
            ->mountAction(TestAction::make('delete')->table($order))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('purchases_orders', [
            'id' => $order->id,
        ]);
    }
}
