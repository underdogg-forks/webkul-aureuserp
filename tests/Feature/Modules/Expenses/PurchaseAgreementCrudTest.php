<?php

namespace Tests\Feature\Modules\Expenses;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Expenses\Enums\RequisitionState;
use Modules\Expenses\Enums\RequisitionType;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\PurchaseAgreementResource\Pages\ListPurchaseAgreements;
use Modules\Expenses\Models\Partner;
use Modules\Expenses\Models\Requisition;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class PurchaseAgreementCrudTest extends TestCase
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
    public function it_lists_purchase_agreements(): void
    {
        /* Arrange */
        $agreement1 = Requisition::create([
            'name'        => 'PA001',
            'partner_id'  => $this->partner->id,
            'company_id'  => $this->company->id,
            'state'       => RequisitionState::ONGOING,
            'type'        => RequisitionType::AGREEMENT,
            'date_start'  => now(),
            'user_id'     => $this->user->id,
            'creator_id'  => $this->user->id,
        ]);

        $agreement2 = Requisition::create([
            'name'        => 'PA002',
            'partner_id'  => $this->partner->id,
            'company_id'  => $this->company->id,
            'state'       => RequisitionState::DRAFT,
            'type'        => RequisitionType::AGREEMENT,
            'date_start'  => now(),
            'user_id'     => $this->user->id,
            'creator_id'  => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListPurchaseAgreements::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$agreement1, $agreement2]);
    }

    #[Test]
    public function it_creates_a_purchase_agreement(): void
    {
        /* Arrange */
        $payload = [
            'partner_id' => $this->partner->id,
            'date_start' => now()->format('Y-m-d'),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPurchaseAgreements::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('purchases_requisitions', [
            'partner_id' => $payload['partner_id'],
            'type'       => RequisitionType::AGREEMENT->value,
        ]);
    }

    #[Test]
    public function it_updates_a_purchase_agreement(): void
    {
        /* Arrange */
        $agreement = Requisition::create([
            'name'        => 'PA003',
            'partner_id'  => $this->partner->id,
            'company_id'  => $this->company->id,
            'state'       => RequisitionState::DRAFT,
            'type'        => RequisitionType::AGREEMENT,
            'date_start'  => now(),
            'user_id'     => $this->user->id,
            'creator_id'  => $this->user->id,
            'description' => 'Original Description',
        ]);

        $payload = [
            'description' => 'Updated Description ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPurchaseAgreements::class)
            ->mountAction(TestAction::make('edit')->table($agreement), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('purchases_requisitions', [
            'id'          => $agreement->id,
            'description' => $payload['description'],
        ]);
    }

    #[Test]
    public function it_deletes_a_purchase_agreement(): void
    {
        /* Arrange */
        $agreement = Requisition::create([
            'name'        => 'PA004',
            'partner_id'  => $this->partner->id,
            'company_id'  => $this->company->id,
            'state'       => RequisitionState::DRAFT,
            'type'        => RequisitionType::AGREEMENT,
            'date_start'  => now(),
            'user_id'     => $this->user->id,
            'creator_id'  => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPurchaseAgreements::class)
            ->mountAction(TestAction::make('delete')->table($agreement))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('purchases_requisitions', [
            'id' => $agreement->id,
        ]);
    }
}
