<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\UserResource\Pages\ListUsers;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class UserCrudTest extends TestCase
{
    protected User $adminUser;

    protected Company $company;

    protected Currency $currency;

    protected function setUp(): void
    {
        parent::setUp();

        Model::unguard();

        $this->currency = Currency::create([
            'name'           => 'USD',
            'symbol'         => '$',
            'iso_numeric'    => 840,
            'decimal_places' => 2,
            'full_name'      => 'US Dollar',
            'rounding'       => 0.00,
            'active'         => true,
        ]);

        $this->adminUser = User::factory()->create([
            'name'  => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        $this->adminUser->forceFill([
            'resource_permission' => 'global',
        ])->save();

        $this->company = Company::create([
            'name'        => 'Test Company',
            'company_id'  => (string) Str::uuid(),
            'email'       => 'company@example.com',
            'currency_id' => $this->currency->id,
            'creator_id'  => $this->adminUser->id,
        ]);

        $this->adminUser->forceFill([
            'default_company_id' => $this->company->id,
        ])->save();
    }

    #[Test]
    public function it_lists_users(): void
    {
        /* Arrange */
        $user1 = User::factory()->create([
            'name'  => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $user2 = User::factory()->create([
            'name'  => 'Jane Smith',
            'email' => 'jane@example.com',
        ]);

        /* Act */
        $component = Livewire::actingAs($this->adminUser)
            ->test(ListUsers::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$user1, $user2]);
    }

    #[Test]
    public function it_creates_a_user(): void
    {
        /* Arrange */
        $payload = [
            'name'     => 'New User ' . Str::random(5),
            'email'    => 'newuser' . Str::random(5) . '@example.com',
            'password' => 'password123',
        ];

        /* Act */
        Livewire::actingAs($this->adminUser)
            ->test(ListUsers::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('users', [
            'name'  => $payload['name'],
            'email' => $payload['email'],
        ]);
    }

    #[Test]
    public function it_updates_a_user(): void
    {
        /* Arrange */
        $user = User::factory()->create([
            'name'  => 'Original Name',
            'email' => 'original@example.com',
        ]);

        $payload = [
            'name' => 'Updated Name ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->adminUser)
            ->test(ListUsers::class)
            ->mountAction(TestAction::make('edit')->table($user), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('users', [
            'id'   => $user->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_user(): void
    {
        /* Arrange */
        $user = User::factory()->create([
            'name'  => 'Delete Me',
            'email' => 'deleteme@example.com',
        ]);

        /* Act */
        Livewire::actingAs($this->adminUser)
            ->test(ListUsers::class)
            ->mountAction(TestAction::make('delete')->table($user))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
