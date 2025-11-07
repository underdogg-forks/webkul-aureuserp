<?php

namespace Tests\Feature\Modules\Products;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Enums\ProductType;
use Modules\Core\Models\Category;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Core\Models\Product;
use Modules\Core\Models\UOM;
use Modules\Core\Models\UOMCategory;
use Modules\Products\Filament\Clusters\Products\Resources\LotResource\Pages\ListLots;
use Modules\Products\Models\Lot;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class LotCrudTest extends TestCase
{
    protected User $user;

    protected Product $product;

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

        $uomCategory = UOMCategory::create([
            'name' => 'Unit',
        ]);

        UOM::create([
            'name'        => 'Units',
            'type'        => 'unit',
            'factor'      => 1,
            'rounding'    => 0,
            'category_id' => $uomCategory->id,
        ]);

        $company = Company::create([
            'name'        => 'Acme Corp',
            'company_id'  => (string) Str::uuid(),
            'email'       => 'info@example.com',
            'currency_id' => $currency->id,
            'creator_id'  => $this->user->id,
        ]);

        $this->user->forceFill([
            'default_company_id' => $company->id,
        ])->save();

        $category = Category::factory()->create();

        $this->product = Product::create([
            'name'        => 'Test Product',
            'type'        => ProductType::GOODS->value,
            'price'       => 25.00,
            'cost'        => 10.00,
            'category_id' => $category->id,
            'company_id'  => $company->id,
            'uom_id'      => UOM::first()->id,
            'uom_po_id'   => UOM::first()->id,
            'creator_id'  => $this->user->id,
            'tracking'    => 'lot',
        ]);
    }

    #[Test]
    public function it_lists_lots(): void
    {
        /* Arrange */
        $lot1 = Lot::create([
            'name'       => 'LOT-001',
            'product_id' => $this->product->id,
            'company_id' => $this->user->default_company_id,
            'creator_id' => $this->user->id,
        ]);

        $lot2 = Lot::create([
            'name'       => 'LOT-002',
            'product_id' => $this->product->id,
            'company_id' => $this->user->default_company_id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListLots::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$lot1, $lot2]);
    }

    #[Test]
    public function it_creates_a_lot(): void
    {
        /* Arrange */
        $payload = [
            'name'       => 'LOT-' . Str::random(5),
            'product_id' => $this->product->id,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListLots::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('inventories_lots', [
            'name'       => $payload['name'],
            'product_id' => $this->product->id,
        ]);
    }

    #[Test]
    public function it_updates_a_lot(): void
    {
        /* Arrange */
        $lot = Lot::create([
            'name'       => 'LOT-ORIGINAL',
            'product_id' => $this->product->id,
            'company_id' => $this->user->default_company_id,
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'LOT-UPDATED',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListLots::class)
            ->mountAction(TestAction::make('edit')->table($lot), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('inventories_lots', [
            'id'   => $lot->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_lot(): void
    {
        /* Arrange */
        $lot = Lot::create([
            'name'       => 'LOT-DELETE',
            'product_id' => $this->product->id,
            'company_id' => $this->user->default_company_id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListLots::class)
            ->mountAction(TestAction::make('delete')->table($lot))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('inventories_lots', [
            'id' => $lot->id,
        ]);
    }
}
