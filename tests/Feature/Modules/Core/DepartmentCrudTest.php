<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\DepartmentResource\Pages\ListDepartments;
use Modules\Core\Models\Department;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class DepartmentCrudTest extends TestCase
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
    public function it_lists_departments(): void
    {
        /* Arrange */
        $department = Department::create([
            'name'       => 'Operations',
            'color'      => '#336699',
            'creator_id' => $this->user->id,
        ]);

        $otherDepartment = Department::create([
            'name'       => 'Support',
            'color'      => '#663399',
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListDepartments::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$department, $otherDepartment]);
    }

    #[Test]
    public function it_creates_a_department(): void
    {
        /* Arrange */
        $payload = [
            'name'  => 'Department ' . Str::random(5),
            'color' => '#123456',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListDepartments::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('employees_departments', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_a_department(): void
    {
        /* Arrange */
        $department = Department::create([
            'name'       => 'Finance',
            'color'      => '#112233',
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated ' . $department->name,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListDepartments::class)
            ->mountAction(TestAction::make('edit')->table($department), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('employees_departments', [
            'id'   => $department->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_department(): void
    {
        /* Arrange */
        $department = Department::create([
            'name'       => 'Logistics',
            'color'      => '#445566',
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListDepartments::class)
            ->mountAction(TestAction::make('delete')->table($department))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('employees_departments', [
            'id' => $department->id,
        ]);
    }
}
