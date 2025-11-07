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
use Modules\Products\Filament\Resources\ProductResource\Pages\ListProducts;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class ProductCrudTest extends TestCase
{
    protected User $user;

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

        Category::factory()->create();
    }

    #[Test]
    public function it_lists_products(): void
    {
        /* Arrange */
        $category = Category::first();
        $company  = Company::first();
        $uom      = UOM::first();

        $goods = Product::create([
            'name'        => 'Goods Item',
            'type'        => ProductType::GOODS->value,
            'price'       => 25.00,
            'cost'        => 10.00,
            'category_id' => $category->id,
            'company_id'  => $company->id,
            'uom_id'      => $uom->id,
            'uom_po_id'   => $uom->id,
            'creator_id'  => $this->user->id,
        ]);

        $service = Product::create([
            'name'        => 'Service Item',
            'type'        => ProductType::SERVICE->value,
            'price'       => 40.00,
            'cost'        => 0.00,
            'category_id' => $category->id,
            'company_id'  => $company->id,
            'uom_id'      => $uom->id,
            'uom_po_id'   => $uom->id,
            'creator_id'  => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListProducts::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$goods])
            ->assertCanNotSeeTableRecords([$service]);
    }

    #[Test]
    public function it_creates_a_product(): void
    {
        /* Arrange */
        $category = Category::first();
        $company  = Company::first();

        $payload = [
            'name'        => 'Test Product ' . Str::random(5),
            'type'        => ProductType::GOODS->value,
            'price'       => 19.99,
            'cost'        => 5.50,
            'category_id' => $category->id,
            'company_id'  => $company->id,
        ];

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListProducts::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('products_products', [
            'name'  => $payload['name'],
            'type'  => ProductType::GOODS->value,
            'price' => 19.99,
        ]);
    }

    #[Test]
    public function it_updates_a_product(): void
    {
        /* Arrange */
        $category = Category::first();
        $company  = Company::first();
        $uom      = UOM::first();

        $product = Product::create([
            'name'        => 'Inventory Item',
            'type'        => ProductType::GOODS->value,
            'price'       => 10.00,
            'cost'        => 5.00,
            'category_id' => $category->id,
            'company_id'  => $company->id,
            'uom_id'      => $uom->id,
            'uom_po_id'   => $uom->id,
            'creator_id'  => $this->user->id,
        ]);

        $payload = [
            'name'  => 'Updated ' . $product->name,
            'price' => 12.34,
        ];

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListProducts::class)
            ->mountAction(TestAction::make('edit')->table($product), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('products_products', [
            'id'    => $product->id,
            'name'  => $payload['name'],
            'price' => 12.34,
        ]);
    }

    #[Test]
    public function it_deletes_a_product(): void
    {
        /* Arrange */
        $category = Category::first();
        $company  = Company::first();
        $uom      = UOM::first();

        $product = Product::create([
            'name'        => 'Disposable Item',
            'type'        => ProductType::GOODS->value,
            'price'       => 15.00,
            'cost'        => 7.00,
            'category_id' => $category->id,
            'company_id'  => $company->id,
            'uom_id'      => $uom->id,
            'uom_po_id'   => $uom->id,
            'creator_id'  => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListProducts::class)
            ->mountAction(TestAction::make('delete')->table($product))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('products_products', [
            'id' => $product->id,
        ]);
    }
}
