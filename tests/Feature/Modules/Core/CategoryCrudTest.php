<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\CategoryResource\Pages\ListCategories;
use Modules\Core\Models\Category;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class CategoryCrudTest extends TestCase
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
    public function it_lists_categories(): void
    {
        /* Arrange */
        $visibleCategory = Category::factory()->create();
        $otherCategory   = Category::factory()->create();

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListCategories::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$visibleCategory])
            ->assertCanSeeTableRecords([$otherCategory]);
    }

    #[Test]
    public function it_creates_a_category(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'Test Category ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListCategories::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('products_categories', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_a_category(): void
    {
        /* Arrange */
        $category = Category::factory()->create();

        $payload = [
            'name' => 'Updated ' . $category->name,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListCategories::class)
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
    public function it_deletes_a_category(): void
    {
        /* Arrange */
        $category = Category::factory()->create();

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListCategories::class)
            ->mountAction(TestAction::make('delete')->table($category))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('products_categories', [
            'id' => $category->id,
        ]);
    }
}
