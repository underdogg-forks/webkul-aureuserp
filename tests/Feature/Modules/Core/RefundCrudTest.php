<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Enums\MoveState;
use Modules\Core\Enums\MoveType;
use Modules\Core\Enums\PaymentState;
use Modules\Core\Filament\Resources\RefundResource\Pages\ListRefunds;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Core\Models\Journal;
use Modules\Core\Models\Move;
use Modules\Core\Models\Partner;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class RefundCrudTest extends TestCase
{
    protected User $user;

    protected Company $company;

    protected Currency $currency;

    protected Partner $partner;

    protected Journal $journal;

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

        $this->journal = Journal::firstOrCreate(
            ['code' => 'RBILL'],
            [
                'name'       => 'Vendor Refunds',
                'type'       => 'purchase',
                'company_id' => $this->company->id,
                'creator_id' => $this->user->id,
            ]
        );
    }

    #[Test]
    public function it_lists_refunds(): void
    {
        /* Arrange */
        $refund = Move::create([
            'name'                         => 'RBILL/2024/0001',
            'partner_id'                   => $this->partner->id,
            'company_id'                   => $this->company->id,
            'currency_id'                  => $this->currency->id,
            'journal_id'                   => $this->journal->id,
            'move_type'                    => MoveType::IN_REFUND->value,
            'state'                        => MoveState::DRAFT->value,
            'payment_state'                => PaymentState::NOT_PAID->value,
            'invoice_date'                 => now(),
            'invoice_partner_display_name' => $this->partner->name,
            'creator_id'                   => $this->user->id,
        ]);

        // Create a bill that should not appear in refunds
        $bill = Move::create([
            'name'                         => 'BILL/2024/0001',
            'partner_id'                   => $this->partner->id,
            'company_id'                   => $this->company->id,
            'currency_id'                  => $this->currency->id,
            'journal_id'                   => $this->journal->id,
            'move_type'                    => MoveType::IN_INVOICE->value,
            'state'                        => MoveState::DRAFT->value,
            'payment_state'                => PaymentState::NOT_PAID->value,
            'invoice_date'                 => now(),
            'invoice_partner_display_name' => $this->partner->name,
            'creator_id'                   => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListRefunds::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$refund])
            ->assertCanNotSeeTableRecords([$bill]);
    }

    #[Test]
    public function it_creates_a_refund(): void
    {
        /* Arrange */
        $payload = [
            'partner_id'   => $this->partner->id,
            'invoice_date' => now()->format('Y-m-d'),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListRefunds::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_account_moves', [
            'partner_id' => $payload['partner_id'],
            'move_type'  => MoveType::IN_REFUND->value,
        ]);
    }

    #[Test]
    public function it_updates_a_refund(): void
    {
        /* Arrange */
        $refund = Move::create([
            'name'                         => 'RBILL/2024/0002',
            'partner_id'                   => $this->partner->id,
            'company_id'                   => $this->company->id,
            'currency_id'                  => $this->currency->id,
            'journal_id'                   => $this->journal->id,
            'move_type'                    => MoveType::IN_REFUND->value,
            'state'                        => MoveState::DRAFT->value,
            'payment_state'                => PaymentState::NOT_PAID->value,
            'invoice_date'                 => now(),
            'invoice_partner_display_name' => $this->partner->name,
            'invoice_origin'               => 'Original Reference',
            'creator_id'                   => $this->user->id,
        ]);

        $payload = [
            'invoice_origin' => 'Updated Reference ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListRefunds::class)
            ->mountAction(TestAction::make('edit')->table($refund), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_account_moves', [
            'id'             => $refund->id,
            'invoice_origin' => $payload['invoice_origin'],
        ]);
    }

    #[Test]
    public function it_deletes_a_refund(): void
    {
        /* Arrange */
        $refund = Move::create([
            'name'                         => 'RBILL/2024/0003',
            'partner_id'                   => $this->partner->id,
            'company_id'                   => $this->company->id,
            'currency_id'                  => $this->currency->id,
            'journal_id'                   => $this->journal->id,
            'move_type'                    => MoveType::IN_REFUND->value,
            'state'                        => MoveState::DRAFT->value,
            'payment_state'                => PaymentState::NOT_PAID->value,
            'invoice_date'                 => now(),
            'invoice_partner_display_name' => $this->partner->name,
            'creator_id'                   => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListRefunds::class)
            ->mountAction(TestAction::make('delete')->table($refund))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('accounts_account_moves', [
            'id' => $refund->id,
        ]);
    }
}
