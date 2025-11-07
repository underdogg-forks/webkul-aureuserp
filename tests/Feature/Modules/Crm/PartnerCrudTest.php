<?php

namespace Tests\Feature\Modules\Crm;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Crm\Filament\Resources\PartnerResource\Pages\ListPartners;
use Modules\Crm\Models\Partner;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class PartnerCrudTest extends TestCase
{
    protected User $user;

    protected Company $company;

    protected Currency $currency;

    protected function setUp(): void
    {
        parent::setUp();

        // Model::unguard() removed - Laravel test infrastructure 
        // handles database transactions automatically

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
    public function it_lists_partners(): void
    {
        /* Arrange */
        $partner1 = Partner::create([
            'name'       => 'Partner One',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $partner2 = Partner::create([
            'name'       => 'Partner Two',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListPartners::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$partner1, $partner2]);
    }

    #[Test]
    public function it_creates_a_partner(): void
    {
        /* Arrange */
        $payload = [
            'name'  => 'New Partner ' . Str::random(5),
            'email' => 'newpartner@example.com',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPartners::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('partners_partners', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_a_partner(): void
    {
        /* Arrange */
        $partner = Partner::create([
            'name'       => 'Original Partner',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Partner ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPartners::class)
            ->mountAction(TestAction::make('edit')->table($partner))
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('partners_partners', [
            'id'   => $partner->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_partner(): void
    {
        /* Arrange */
        $partner = Partner::create([
            'name'       => 'Delete Me Partner',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPartners::class)
            ->mountAction(TestAction::make('delete')->table($partner))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('partners_partners', [
            'id' => $partner->id,
        ]);
    }
}
