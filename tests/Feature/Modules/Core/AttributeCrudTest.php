<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\AttributeResource\Pages\ListAttributes;
use Modules\Core\Models\Attribute;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class AttributeCrudTest extends TestCase
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
    public function it_lists_attributes(): void
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
            ->test(ListAttributes::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$attribute1, $attribute2]);
    }

    #[Test]
    public function it_creates_an_attribute(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Attribute ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListAttributes::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('products_attributes', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_an_attribute(): void
    {
        /* Arrange */
        $attribute = Attribute::create([
            'name' => 'Original Attribute',
        ]);

        $payload = [
            'name' => 'Updated Attribute',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListAttributes::class)
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
    public function it_deletes_an_attribute(): void
    {
        /* Arrange */
        $attribute = Attribute::create([
            'name' => 'Delete Attribute',
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListAttributes::class)
            ->mountAction(TestAction::make('delete')->table($attribute))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('products_attributes', [
            'id' => $attribute->id,
        ]);
    }
}
