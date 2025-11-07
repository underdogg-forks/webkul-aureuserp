<?php

namespace Tests\Feature\Modules\Products;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Products\Enums\AllowNewProduct;
use Modules\Products\Filament\Clusters\Configurations\Resources\StorageCategoryResource\Pages\ListStorageCategories;
use Modules\Products\Models\StorageCategory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class StorageCategoryCrudTest extends TestCase
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
    public function it_lists_storage_categories(): void
    {
        /* Arrange */
        $category1 = StorageCategory::create([
            'name'       => 'Heavy Items',
            'max_weight' => 1000.0,
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $category2 = StorageCategory::create([
            'name'       => 'Light Items',
            'max_weight' => 100.0,
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListStorageCategories::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$category1, $category2]);
    }

    #[Test]
    public function it_creates_a_storage_category(): void
    {
        /* Arrange */
        $payload = [
            'name'                => 'New Category ' . Str::random(5),
            'max_weight'          => 500.0,
            'allow_new_products'  => AllowNewProduct::MIXED->value,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListStorageCategories::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('inventories_storage_categories', [
            'name'       => $payload['name'],
            'max_weight' => $payload['max_weight'],
        ]);
    }

    #[Test]
    public function it_updates_a_storage_category(): void
    {
        /* Arrange */
        $category = StorageCategory::create([
            'name'       => 'Original Category',
            'max_weight' => 1000.0,
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Category',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListStorageCategories::class)
            ->mountAction(TestAction::make('edit')->table($category), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('inventories_storage_categories', [
            'id'   => $category->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_storage_category(): void
    {
        /* Arrange */
        $category = StorageCategory::create([
            'name'       => 'Delete Category',
            'max_weight' => 1000.0,
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListStorageCategories::class)
            ->mountAction(TestAction::make('delete')->table($category))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('inventories_storage_categories', [
            'id' => $category->id,
        ]);
    }
}
