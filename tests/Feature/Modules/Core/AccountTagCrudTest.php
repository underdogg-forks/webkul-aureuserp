<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\AccountTagResource\Pages\ListAccountTags;
use Modules\Core\Models\AccountTag;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class AccountTagCrudTest extends TestCase
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
    public function it_lists_account_tags(): void
    {
        /* Arrange */
        $tag1 = AccountTag::create([
            'name' => 'Fixed Assets',
        ]);

        $tag2 = AccountTag::create([
            'name' => 'Payable',
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListAccountTags::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$tag1, $tag2]);
    }

    #[Test]
    public function it_creates_an_account_tag(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Account Tag ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListAccountTags::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_account_tags', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_an_account_tag(): void
    {
        /* Arrange */
        $tag = AccountTag::create([
            'name' => 'Original Tag',
        ]);

        $payload = [
            'name' => 'Updated Tag',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListAccountTags::class)
            ->mountAction(TestAction::make('edit')->table($tag), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_account_tags', [
            'id'   => $tag->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_an_account_tag(): void
    {
        /* Arrange */
        $tag = AccountTag::create([
            'name' => 'Delete Tag',
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListAccountTags::class)
            ->mountAction(TestAction::make('delete')->table($tag))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('accounts_account_tags', [
            'id' => $tag->id,
        ]);
    }
}
