<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Enums\AccountType;
use Modules\Core\Filament\Resources\AccountResource\Pages\ListAccounts;
use Modules\Core\Models\Account;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class AccountCrudTest extends TestCase
{
    protected User $user;

    protected Company $company;

    protected Currency $currency;

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
    }

    #[Test]
    public function it_lists_accounts(): void
    {
        /* Arrange */
        $account1 = Account::create([
            'code'         => '1000',
            'name'         => 'Cash Account',
            'account_type' => AccountType::LIQUIDITY->value,
            'company_id'   => $this->company->id,
            'creator_id'   => $this->user->id,
        ]);

        $account2 = Account::create([
            'code'         => '2000',
            'name'         => 'Accounts Receivable',
            'account_type' => AccountType::RECEIVABLE->value,
            'company_id'   => $this->company->id,
            'creator_id'   => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListAccounts::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$account1, $account2]);
    }

    #[Test]
    public function it_creates_an_account(): void
    {
        /* Arrange */
        $payload = [
            'code'         => '3000',
            'name'         => 'New Account ' . Str::random(5),
            'account_type' => AccountType::EXPENSE->value,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListAccounts::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_accounts', [
            'code'         => $payload['code'],
            'name'         => $payload['name'],
            'account_type' => $payload['account_type'],
        ]);
    }

    #[Test]
    public function it_updates_an_account(): void
    {
        /* Arrange */
        $account = Account::create([
            'code'         => '4000',
            'name'         => 'Original Account Name',
            'account_type' => AccountType::INCOME->value,
            'company_id'   => $this->company->id,
            'creator_id'   => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Account Name ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListAccounts::class)
            ->mountAction(TestAction::make('edit')->table($account), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_accounts', [
            'id'   => $account->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_an_account(): void
    {
        /* Arrange */
        $account = Account::create([
            'code'         => '5000',
            'name'         => 'Delete Me Account',
            'account_type' => AccountType::OTHER->value,
            'company_id'   => $this->company->id,
            'creator_id'   => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListAccounts::class)
            ->mountAction(TestAction::make('delete')->table($account))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('accounts_accounts', [
            'id' => $account->id,
        ]);
    }
}
