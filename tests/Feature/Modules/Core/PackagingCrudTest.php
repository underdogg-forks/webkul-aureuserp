<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\PackagingResource\Pages\ManagePackagings;
use Modules\Core\Models\Packaging;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class PackagingCrudTest extends TestCase
{
    protected User $user;

    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();

        Model::unguard();

        $this->user = User::factory()->create();

        $this->user->forceFill([
            'resource_permission' => 'global',
        ])->save();

        $currency = Currency::create([
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
            'currency_id' => $currency->id,
            'creator_id'  => $this->user->id,
        ]);

        $this->user->forceFill([
            'default_company_id' => $this->company->id,
        ])->save();
    }

    #[Test]
    public function it_lists_packagings(): void
    {
        /* Arrange */
        $packaging1 = Packaging::create([
            'name'       => 'Box',
            'qty'        => 12,
            'company_id' => $this->company->id,
        ]);

        $packaging2 = Packaging::create([
            'name'       => 'Pallet',
            'qty'        => 100,
            'company_id' => $this->company->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ManagePackagings::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$packaging1, $packaging2]);
    }

    #[Test]
    public function it_creates_a_packaging(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Packaging ' . Str::random(5),
            'qty'  => 24,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManagePackagings::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('products_packagings', [
            'name' => $payload['name'],
            'qty'  => $payload['qty'],
        ]);
    }

    #[Test]
    public function it_updates_a_packaging(): void
    {
        /* Arrange */
        $packaging = Packaging::create([
            'name'       => 'Original Packaging',
            'qty'        => 12,
            'company_id' => $this->company->id,
        ]);

        $payload = [
            'name' => 'Updated Packaging',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManagePackagings::class)
            ->mountAction(TestAction::make('edit')->table($packaging), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('products_packagings', [
            'id'   => $packaging->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_packaging(): void
    {
        /* Arrange */
        $packaging = Packaging::create([
            'name'       => 'Delete Packaging',
            'qty'        => 12,
            'company_id' => $this->company->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManagePackagings::class)
            ->mountAction(TestAction::make('delete')->table($packaging))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('products_packagings', [
            'id' => $packaging->id,
        ]);
    }
}
