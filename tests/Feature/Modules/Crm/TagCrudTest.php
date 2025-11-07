<?php

namespace Tests\Feature\Modules\Crm;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Crm\Filament\Resources\TagResource\Pages\ManageTags;
use Modules\Crm\Models\Tag;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class TagCrudTest extends TestCase
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
    public function it_lists_tags(): void
    {
        /* Arrange */
        $visibleTag = Tag::factory()->create();
        $otherTag   = Tag::factory()->create();

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ManageTags::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$visibleTag])
            ->assertCanSeeTableRecords([$otherTag]);
    }

    #[Test]
    public function it_creates_a_tag(): void
    {
        /* Arrange */
        $payload = [
            'name'  => 'Tag ' . Str::random(5),
            'color' => '#ff0000',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageTags::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('partners_tags', [
            'name'  => $payload['name'],
            'color' => $payload['color'],
        ]);
    }

    #[Test]
    public function it_updates_a_tag(): void
    {
        /* Arrange */
        $tag = Tag::factory()->create();

        $payload = [
            'name'  => 'Updated ' . $tag->name,
            'color' => '#00ff00',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageTags::class)
            ->mountAction(TestAction::make('edit')->table($tag), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('partners_tags', [
            'id'    => $tag->id,
            'name'  => $payload['name'],
            'color' => $payload['color'],
        ]);
    }

    #[Test]
    public function it_soft_deletes_a_tag(): void
    {
        /* Arrange */
        $tag = Tag::factory()->create();

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageTags::class)
            ->mountAction(TestAction::make('delete')->table($tag))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('partners_tags', [
            'id' => $tag->id,
        ]);
    }
}
