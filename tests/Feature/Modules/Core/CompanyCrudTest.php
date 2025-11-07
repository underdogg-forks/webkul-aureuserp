<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\CompanyResource\Pages\ListCompanies;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class CompanyCrudTest extends TestCase
{
    protected User $user;

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
    }

    #[Test]
    public function it_lists_companies(): void
    {
        /* Arrange */
        $company1 = Company::create([
            'name'        => 'Acme Corporation',
            'company_id'  => (string) Str::uuid(),
            'email'       => 'info@acme.com',
            'currency_id' => $this->currency->id,
            'creator_id'  => $this->user->id,
        ]);

        $company2 = Company::create([
            'name'        => 'Beta Industries',
            'company_id'  => (string) Str::uuid(),
            'email'       => 'contact@beta.com',
            'currency_id' => $this->currency->id,
            'creator_id'  => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListCompanies::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$company1, $company2]);
    }

    #[Test]
    public function it_creates_a_company(): void
    {
        /* Arrange */
        $payload = [
            'name'        => 'New Company ' . Str::random(5),
            'email'       => 'newcompany@example.com',
            'currency_id' => $this->currency->id,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListCompanies::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('companies', [
            'name'  => $payload['name'],
            'email' => $payload['email'],
        ]);
    }

    #[Test]
    public function it_updates_a_company(): void
    {
        /* Arrange */
        $company = Company::create([
            'name'        => 'Original Company Name',
            'company_id'  => (string) Str::uuid(),
            'email'       => 'original@example.com',
            'currency_id' => $this->currency->id,
            'creator_id'  => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Company Name ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListCompanies::class)
            ->mountAction(TestAction::make('edit')->table($company), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('companies', [
            'id'   => $company->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_company(): void
    {
        /* Arrange */
        $company = Company::create([
            'name'        => 'Delete Me Company',
            'company_id'  => (string) Str::uuid(),
            'email'       => 'deleteme@example.com',
            'currency_id' => $this->currency->id,
            'creator_id'  => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListCompanies::class)
            ->mountAction(TestAction::make('delete')->table($company))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('companies', [
            'id' => $company->id,
        ]);
    }
}
