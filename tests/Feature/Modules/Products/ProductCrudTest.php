<?php

namespace Tests\Feature\Modules\Products;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;
use Webkul\Product\Enums\ProductType;
use Webkul\Product\Filament\Resources\ProductResource\Pages\ListProducts;
use Webkul\Product\Models\Category;
use Webkul\Product\Models\Product;
use Webkul\Support\Models\Company;
use Webkul\Support\Models\UOM;

/**
 * @group smoke
 */
class ProductCrudTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Prevent mass assignment issues in tests when using factories
        Model::unguard();

        $this->user = User::factory()->create();

        // Ensure required related records exist for form defaults/relationships
        UOM::factory()->create();
        Category::factory()->create();
        Company::factory()->create();
    }

    public function it_lists_products(): void
    {
        /* Arrange */
        $goods   = Product::factory()->create(['type' => ProductType::GOODS]);
        $service = Product::factory()->create(['type' => ProductType::SERVICE]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListProducts::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$goods])
            ->assertCanNotSeeTableRecords([$service]);
    }

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

    public function it_updates_a_product(): void
    {
        /* Arrange */
        $product = Product::factory()->create([
            'type'  => ProductType::GOODS,
            'price' => 10.00,
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

    public function it_deletes_a_product(): void
    {
        /* Arrange */
        $product = Product::factory()->create();

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
