<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\JournalResource\Pages\ListJournals;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Core\Models\Journal;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class JournalCrudTest extends TestCase
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
    public function it_lists_journals(): void
    {
        /* Arrange */
        $journal1 = Journal::create([
            'name'       => 'Cash Journal',
            'code'       => 'CASH1',
            'type'       => 'cash',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $journal2 = Journal::create([
            'name'       => 'Bank Journal',
            'code'       => 'BANK1',
            'type'       => 'bank',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListJournals::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$journal1, $journal2]);
    }

    #[Test]
    public function it_creates_a_journal(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Journal ' . Str::random(5),
            'code' => 'NJ' . Str::random(3),
            'type' => 'sale',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListJournals::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_journals', [
            'name' => $payload['name'],
            'code' => $payload['code'],
            'type' => $payload['type'],
        ]);
    }

    #[Test]
    public function it_updates_a_journal(): void
    {
        /* Arrange */
        $journal = Journal::create([
            'name'       => 'Original Journal',
            'code'       => 'ORIG1',
            'type'       => 'general',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Journal ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListJournals::class)
            ->mountAction(TestAction::make('edit')->table($journal), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_journals', [
            'id'   => $journal->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_journal(): void
    {
        /* Arrange */
        $journal = Journal::create([
            'name'       => 'Delete Me Journal',
            'code'       => 'DEL1',
            'type'       => 'general',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListJournals::class)
            ->mountAction(TestAction::make('delete')->table($journal))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('accounts_journals', [
            'id' => $journal->id,
        ]);
    }
}
