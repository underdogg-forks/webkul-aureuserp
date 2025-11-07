<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\PluginResource\Pages\ListPlugins;
use Modules\Core\Models\Plugin;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class PluginCrudTest extends TestCase
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
    public function it_lists_plugins(): void
    {
        /* Arrange */
        $plugin1 = Plugin::create([
            'name'           => 'CRM Plugin',
            'author'         => 'Webkul',
            'is_active'      => true,
            'is_installed'   => true,
            'latest_version' => '1.0.0',
        ]);

        $plugin2 = Plugin::create([
            'name'           => 'Accounting Plugin',
            'author'         => 'Webkul',
            'is_active'      => true,
            'is_installed'   => true,
            'latest_version' => '1.0.0',
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListPlugins::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$plugin1, $plugin2]);
    }

    #[Test]
    public function it_creates_a_plugin(): void
    {
        /* Arrange */
        $payload = [
            'name'           => 'New Plugin ' . Str::random(5),
            'author'         => 'Test Author',
            'is_active'      => true,
            'is_installed'   => true,
            'latest_version' => '1.0.0',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPlugins::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('plugins', [
            'name'   => $payload['name'],
            'author' => $payload['author'],
        ]);
    }

    #[Test]
    public function it_updates_a_plugin(): void
    {
        /* Arrange */
        $plugin = Plugin::create([
            'name'           => 'Original Plugin',
            'author'         => 'Original Author',
            'is_active'      => true,
            'is_installed'   => true,
            'latest_version' => '1.0.0',
        ]);

        $payload = [
            'name' => 'Updated Plugin',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPlugins::class)
            ->mountAction(TestAction::make('edit')->table($plugin), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('plugins', [
            'id'   => $plugin->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_plugin(): void
    {
        /* Arrange */
        $plugin = Plugin::create([
            'name'           => 'Delete Plugin',
            'author'         => 'Test Author',
            'is_active'      => false,
            'is_installed'   => false,
            'latest_version' => '1.0.0',
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPlugins::class)
            ->mountAction(TestAction::make('delete')->table($plugin))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('plugins', [
            'id' => $plugin->id,
        ]);
    }
}
