<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\FieldResource\Pages\ListFields;
use Modules\Core\Models\Field;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class FieldCrudTest extends TestCase
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
    public function it_lists_fields(): void
    {
        /* Arrange */
        $field1 = Field::create([
            'code'              => 'custom_field_1',
            'name'              => 'Custom Field 1',
            'type'              => 'string',
            'customizable_type' => 'Modules\Core\Models\Product',
        ]);

        $field2 = Field::create([
            'code'              => 'custom_field_2',
            'name'              => 'Custom Field 2',
            'type'              => 'text',
            'customizable_type' => 'Modules\Core\Models\Partner',
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListFields::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$field1, $field2]);
    }

    #[Test]
    public function it_creates_a_field(): void
    {
        /* Arrange */
        $payload = [
            'code'              => 'custom_field_' . Str::random(5),
            'name'              => 'New Custom Field',
            'type'              => 'string',
            'customizable_type' => 'Modules\Core\Models\Product',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListFields::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('custom_fields', [
            'code' => $payload['code'],
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_a_field(): void
    {
        /* Arrange */
        $field = Field::create([
            'code'              => 'original_field',
            'name'              => 'Original Field',
            'type'              => 'string',
            'customizable_type' => 'Modules\Core\Models\Product',
        ]);

        $payload = [
            'name' => 'Updated Field',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListFields::class)
            ->mountAction(TestAction::make('edit')->table($field), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('custom_fields', [
            'id'   => $field->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_soft_deletes_a_field(): void
    {
        /* Arrange */
        $field = Field::create([
            'code'              => 'delete_field',
            'name'              => 'Delete Field',
            'type'              => 'string',
            'customizable_type' => 'Modules\Core\Models\Product',
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListFields::class)
            ->mountAction(TestAction::make('delete')->table($field))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('custom_fields', [
            'id' => $field->id,
        ]);
    }
}
