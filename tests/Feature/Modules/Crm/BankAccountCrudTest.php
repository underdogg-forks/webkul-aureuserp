<?php

namespace Tests\Feature\Modules\Crm;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Crm\Filament\Resources\BankAccountResource\Pages\ManageBankAccounts;
use Modules\Crm\Models\Bank;
use Modules\Crm\Models\BankAccount;
use Modules\Crm\Models\Partner;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class BankAccountCrudTest extends TestCase
{
    protected User $user;

    protected Company $company;

    protected Currency $currency;

    protected Bank $bank;

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

        $this->bank = Bank::create([
            'name'       => 'Test Bank',
            'code'       => 'TB001',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $this->partner = Partner::create([
            'name'       => 'Test Partner',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);
    }

    #[Test]
    public function it_lists_bank_accounts(): void
    {
        /* Arrange */
        $bankAccount1 = BankAccount::create([
            'account_number' => 'ACC123456',
            'bank_id'        => $this->bank->id,
            'partner_id'     => $this->partner->id,
            'company_id'     => $this->company->id,
            'creator_id'     => $this->user->id,
        ]);

        $bankAccount2 = BankAccount::create([
            'account_number' => 'ACC789012',
            'bank_id'        => $this->bank->id,
            'partner_id'     => $this->partner->id,
            'company_id'     => $this->company->id,
            'creator_id'     => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ManageBankAccounts::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$bankAccount1, $bankAccount2]);
    }

    #[Test]
    public function it_creates_a_bank_account(): void
    {
        /* Arrange */
        $payload = [
            'account_number' => 'ACC' . Str::random(8),
            'bank_id'        => $this->bank->id,
            'partner_id'     => $this->partner->id,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageBankAccounts::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('partners_bank_accounts', [
            'account_number' => $payload['account_number'],
            'bank_id'        => $payload['bank_id'],
        ]);
    }

    #[Test]
    public function it_updates_a_bank_account(): void
    {
        /* Arrange */
        $bankAccount = BankAccount::create([
            'account_number' => 'ACC111222',
            'bank_id'        => $this->bank->id,
            'partner_id'     => $this->partner->id,
            'company_id'     => $this->company->id,
            'creator_id'     => $this->user->id,
        ]);

        $payload = [
            'account_number' => 'ACC' . Str::random(8),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageBankAccounts::class)
            ->mountAction(TestAction::make('edit')->table($bankAccount), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('partners_bank_accounts', [
            'id'             => $bankAccount->id,
            'account_number' => $payload['account_number'],
        ]);
    }

    #[Test]
    public function it_deletes_a_bank_account(): void
    {
        /* Arrange */
        $bankAccount = BankAccount::create([
            'account_number' => 'ACCDEL999',
            'bank_id'        => $this->bank->id,
            'partner_id'     => $this->partner->id,
            'company_id'     => $this->company->id,
            'creator_id'     => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageBankAccounts::class)
            ->mountAction(TestAction::make('delete')->table($bankAccount))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('partners_bank_accounts', [
            'id' => $bankAccount->id,
        ]);
    }
}
