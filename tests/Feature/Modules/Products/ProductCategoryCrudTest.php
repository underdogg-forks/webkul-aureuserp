<?php

namespace Tests\Feature\Modules\Products;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Products\Filament\Clusters\Configurations\Resources\ProductCategoryResource\Pages\ListProductCategories;
use Modules\Core\Models\Category;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class ProductCategoryCrudTest extends TestCase
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
    }

    #[Test]
    public function it_lists_product_categories(): void
    {
        /* Arrange */
        $category1 = Category::create([
            'name'      => 'Electronics',
            'full_name' => 'Electronics',
        ]);

        $category2 = Category::create([
            'name'      => 'Furniture',
            'full_name' => 'Furniture',
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListProductCategories::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$category1, $category2]);
    }

    #[Test]
    public function it_creates_a_product_category(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Product Category ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListProductCategories::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('products_categories', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_a_product_category(): void
    {
        /* Arrange */
        $category = Category::create([
            'name'      => 'Original Product Category',
            'full_name' => 'Original Product Category',
        ]);

        $payload = [
            'name' => 'Updated Product Category',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListProductCategories::class)
            ->mountAction(TestAction::make('edit')->table($category), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('products_categories', [
            'id'   => $category->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_product_category(): void
    {
        /* Arrange */
        $category = Category::create([
            'name'      => 'Delete Product Category',
            'full_name' => 'Delete Product Category',
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListProductCategories::class)
            ->mountAction(TestAction::make('delete')->table($category))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('products_categories', [
            'id' => $category->id,
        ]);
    }
}
