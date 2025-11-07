<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\EmployeeResource\Pages\ListEmployees;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use Modules\Core\Models\Employee;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class EmployeeCrudTest extends TestCase
{
    protected User $user;

    protected Company $company;

    protected Currency $currency;

    protected function setUp(): void
    {
        parent::setUp();

        Model::unguard();

        $this->user = User::factory()->create();

        $this->user->forceFill([
            'resource_permission' => 'global',
        ])->save();

        $this->currency = Currency::create([
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
            'currency_id' => $this->currency->id,
            'creator_id'  => $this->user->id,
        ]);

        $this->user->forceFill([
            'default_company_id' => $this->company->id,
        ])->save();
    }

    #[Test]
    public function it_lists_employees(): void
    {
        /* Arrange */
        $employee1 = Employee::create([
            'name'       => 'John Doe',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $employee2 = Employee::create([
            'name'       => 'Jane Smith',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListEmployees::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$employee1, $employee2]);
    }

    #[Test]
    public function it_creates_an_employee(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Employee ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListEmployees::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('employees_employees', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_an_employee(): void
    {
        /* Arrange */
        $employee = Employee::create([
            'name'       => 'Original Employee',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Employee ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListEmployees::class)
            ->mountAction(TestAction::make('edit')->table($employee), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('employees_employees', [
            'id'   => $employee->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_an_employee(): void
    {
        /* Arrange */
        $employee = Employee::create([
            'name'       => 'Delete Me Employee',
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListEmployees::class)
            ->mountAction(TestAction::make('delete')->table($employee))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('employees_employees', [
            'id' => $employee->id,
        ]);
    }
}
