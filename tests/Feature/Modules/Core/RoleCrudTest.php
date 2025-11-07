<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\RoleResource\Pages\ListRoles;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * @group smoke
 */
class RoleCrudTest extends TestCase
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
    public function it_lists_roles(): void
    {
        /* Arrange */
        $role1 = Role::create([
            'name'       => 'Test Role 1',
            'guard_name' => 'web',
        ]);

        $role2 = Role::create([
            'name'       => 'Test Role 2',
            'guard_name' => 'web',
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListRoles::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$role1, $role2]);
    }

    #[Test]
    public function it_creates_a_role(): void
    {
        /* Arrange */
        $payload = [
            'name'       => 'New Role ' . Str::random(5),
            'guard_name' => 'web',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListRoles::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('roles', [
            'name'       => $payload['name'],
            'guard_name' => 'web',
        ]);
    }

    #[Test]
    public function it_updates_a_role(): void
    {
        /* Arrange */
        $role = Role::create([
            'name'       => 'Original Role',
            'guard_name' => 'web',
        ]);

        $payload = [
            'name' => 'Updated Role ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListRoles::class)
            ->mountAction(TestAction::make('edit')->table($role), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('roles', [
            'id'   => $role->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_role(): void
    {
        /* Arrange */
        $role = Role::create([
            'name'       => 'Role To Delete',
            'guard_name' => 'web',
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListRoles::class)
            ->mountAction(TestAction::make('delete')->table($role))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('roles', [
            'id' => $role->id,
        ]);
    }
}
