<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\PriceListResource\Pages\ListPriceLists;
use Modules\Core\Models\PriceList;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class PriceListCrudTest extends TestCase
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
    public function it_lists_price_lists(): void
    {
        /* Arrange */
        $priceList1 = PriceList::create([
            'name'        => 'Retail',
            'currency_id' => $this->company->currency_id,
            'company_id'  => $this->company->id,
        ]);

        $priceList2 = PriceList::create([
            'name'        => 'Wholesale',
            'currency_id' => $this->company->currency_id,
            'company_id'  => $this->company->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListPriceLists::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$priceList1, $priceList2]);
    }

    #[Test]
    public function it_creates_a_price_list(): void
    {
        /* Arrange */
        $payload = [
            'name'        => 'New Price List ' . Str::random(5),
            'currency_id' => $this->company->currency_id,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPriceLists::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('sales_price_lists', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_a_price_list(): void
    {
        /* Arrange */
        $priceList = PriceList::create([
            'name'        => 'Original Price List',
            'currency_id' => $this->company->currency_id,
            'company_id'  => $this->company->id,
        ]);

        $payload = [
            'name' => 'Updated Price List',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPriceLists::class)
            ->mountAction(TestAction::make('edit')->table($priceList), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('sales_price_lists', [
            'id'   => $priceList->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_price_list(): void
    {
        /* Arrange */
        $priceList = PriceList::create([
            'name'        => 'Delete Price List',
            'currency_id' => $this->company->currency_id,
            'company_id'  => $this->company->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPriceLists::class)
            ->mountAction(TestAction::make('delete')->table($priceList))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('sales_price_lists', [
            'id' => $priceList->id,
        ]);
    }
}
