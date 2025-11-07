<?php

namespace Tests\Feature\Modules\Crm;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Crm\Filament\Resources\BankResource\Pages\ManageBanks;
use Modules\Crm\Models\Bank;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class BankCrudTest extends TestCase
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
    public function it_lists_banks(): void
    {
        /* Arrange */
        $bank1 = Bank::create([
            'name'       => 'First National Bank',
            'code'       => 'FNB001',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $bank2 = Bank::create([
            'name'       => 'Second State Bank',
            'code'       => 'SSB002',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ManageBanks::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$bank1, $bank2]);
    }

    #[Test]
    public function it_creates_a_bank(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Bank ' . Str::random(5),
            'code' => 'NB' . Str::random(3),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageBanks::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('banks', [
            'name' => $payload['name'],
            'code' => $payload['code'],
        ]);
    }

    #[Test]
    public function it_updates_a_bank(): void
    {
        /* Arrange */
        $bank = Bank::create([
            'name'       => 'Original Bank Name',
            'code'       => 'ORIG',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Bank Name ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageBanks::class)
            ->mountAction(TestAction::make('edit')->table($bank), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('banks', [
            'id'   => $bank->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_bank(): void
    {
        /* Arrange */
        $bank = Bank::create([
            'name'       => 'Delete Me Bank',
            'code'       => 'DEL',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageBanks::class)
            ->mountAction(TestAction::make('delete')->table($bank))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('banks', [
            'id' => $bank->id,
        ]);
    }
}
