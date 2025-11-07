<?php

namespace Tests\Feature\Modules\Products;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Products\Filament\Clusters\Configurations\Resources\ProductAttributeResource\Pages\ListProductAttributes;
use Modules\Products\Models\Attribute;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class ProductAttributeCrudTest extends TestCase
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
    public function it_lists_product_attributes(): void
    {
        /* Arrange */
        $attribute1 = Attribute::create([
            'name' => 'Color',
        ]);

        $attribute2 = Attribute::create([
            'name' => 'Size',
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListProductAttributes::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$attribute1, $attribute2]);
    }

    #[Test]
    public function it_creates_a_product_attribute(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Product Attribute ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListProductAttributes::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('products_attributes', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_a_product_attribute(): void
    {
        /* Arrange */
        $attribute = Attribute::create([
            'name' => 'Original Product Attribute',
        ]);

        $payload = [
            'name' => 'Updated Product Attribute',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListProductAttributes::class)
            ->mountAction(TestAction::make('edit')->table($attribute), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('products_attributes', [
            'id'   => $attribute->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_product_attribute(): void
    {
        /* Arrange */
        $attribute = Attribute::create([
            'name' => 'Delete Product Attribute',
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListProductAttributes::class)
            ->mountAction(TestAction::make('delete')->table($attribute))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('products_attributes', [
            'id' => $attribute->id,
        ]);
    }
}
