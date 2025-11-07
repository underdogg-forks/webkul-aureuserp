<?php

namespace Tests\Feature\Modules\Payments;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Enums\PaymentType;
use Modules\Core\Filament\Resources\PaymentsResource\Pages\ListPayments;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Core\Models\Journal;
use Modules\Core\Models\Partner;
use Modules\Core\Models\PaymentMethodLine;
use Modules\Payments\Enums\PaymentStatus;
use Modules\Payments\Models\Payment;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class PaymentCrudTest extends TestCase
{
    protected User $user;

    protected Company $company;

    protected Currency $currency;

    protected Partner $partner;

    protected PaymentMethodLine $paymentMethodLine;

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

        // Create Journal if needed
        $journal = Journal::firstOrCreate(
            ['code' => 'CSH1'],
            [
                'name'       => 'Cash',
                'type'       => 'cash',
                'company_id' => $this->company->id,
                'creator_id' => $this->user->id,
            ]
        );

        // Create Payment Method Line if needed
        $this->paymentMethodLine = PaymentMethodLine::firstOrCreate(
            ['name' => 'Manual'],
            [
                'code'       => 'manual',
                'company_id' => $this->company->id,
            ]
        );
    }

    #[Test]
    public function it_lists_payments(): void
    {
        /* Arrange */
        $payment = Payment::create([
            'partner_id'             => $this->partner->id,
            'payment_type'           => PaymentType::RECEIVE->value,
            'amount'                 => 100.00,
            'date'                   => now(),
            'state'                  => PaymentStatus::DRAFT->value,
            'company_id'             => $this->company->id,
            'currency_id'            => $this->currency->id,
            'payment_method_line_id' => $this->paymentMethodLine->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListPayments::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$payment]);
    }

    #[Test]
    public function it_creates_a_payment(): void
    {
        /* Arrange */
        $payload = [
            'partner_id'             => $this->partner->id,
            'payment_type'           => PaymentType::RECEIVE->value,
            'amount'                 => 250.00,
            'date'                   => now()->format('Y-m-d'),
            'memo'                   => 'Test payment ' . Str::random(5),
            'payment_method_line_id' => $this->paymentMethodLine->id,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPayments::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_account_payments', [
            'partner_id'   => $payload['partner_id'],
            'payment_type' => PaymentType::RECEIVE->value,
            'amount'       => 250.00,
        ]);
    }

    #[Test]
    public function it_updates_a_payment(): void
    {
        /* Arrange */
        $payment = Payment::create([
            'partner_id'             => $this->partner->id,
            'payment_type'           => PaymentType::RECEIVE->value,
            'amount'                 => 150.00,
            'date'                   => now(),
            'state'                  => PaymentStatus::DRAFT->value,
            'company_id'             => $this->company->id,
            'currency_id'            => $this->currency->id,
            'payment_method_line_id' => $this->paymentMethodLine->id,
            'memo'                   => 'Original memo',
        ]);

        $payload = [
            'amount' => 175.00,
            'memo'   => 'Updated memo ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPayments::class)
            ->mountAction(TestAction::make('edit')->table($payment), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_account_payments', [
            'id'     => $payment->id,
            'amount' => 175.00,
            'memo'   => $payload['memo'],
        ]);
    }

    #[Test]
    public function it_deletes_a_payment(): void
    {
        /* Arrange */
        $payment = Payment::create([
            'partner_id'             => $this->partner->id,
            'payment_type'           => PaymentType::RECEIVE->value,
            'amount'                 => 300.00,
            'date'                   => now(),
            'state'                  => PaymentStatus::DRAFT->value,
            'company_id'             => $this->company->id,
            'currency_id'            => $this->currency->id,
            'payment_method_line_id' => $this->paymentMethodLine->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPayments::class)
            ->mountAction(TestAction::make('delete')->table($payment))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('accounts_account_payments', [
            'id' => $payment->id,
        ]);
    }
}
