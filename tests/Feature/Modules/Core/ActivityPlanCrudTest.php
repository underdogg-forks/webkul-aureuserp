<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Clusters\Configurations\Resources\ActivityPlanResource\Pages\ListActivityPlans;
use Modules\Core\Models\ActivityPlan;
use Modules\Core\Models\Company;
use Modules\Core\Models\Currency;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class ActivityPlanCrudTest extends TestCase
{
    protected User $user;

    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();

        Model::unguard();

        $this->user = User::factory()->create();

        $this->user->forceFill([
            'resource_permission' => 'global',
        ])->save();

        $currency = Currency::create([
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
            'currency_id' => $currency->id,
            'creator_id'  => $this->user->id,
        ]);

        $this->user->forceFill([
            'default_company_id' => $this->company->id,
        ])->save();
    }

    #[Test]
    public function it_lists_activity_plans(): void
    {
        /* Arrange */
        $activityPlan1 = ActivityPlan::create([
            'name'       => 'Sales Follow-up',
            'is_active'  => true,
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $activityPlan2 = ActivityPlan::create([
            'name'       => 'Customer Support',
            'is_active'  => true,
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListActivityPlans::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$activityPlan1, $activityPlan2]);
    }

    #[Test]
    public function it_creates_an_activity_plan(): void
    {
        /* Arrange */
        $payload = [
            'name'      => 'New Activity Plan ' . Str::random(5),
            'is_active' => true,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListActivityPlans::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('activity_plans', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_an_activity_plan(): void
    {
        /* Arrange */
        $activityPlan = ActivityPlan::create([
            'name'       => 'Original Activity Plan',
            'is_active'  => true,
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        $payload = [
            'name' => 'Updated Activity Plan',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListActivityPlans::class)
            ->mountAction(TestAction::make('edit')->table($activityPlan), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('activity_plans', [
            'id'   => $activityPlan->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_soft_deletes_an_activity_plan(): void
    {
        /* Arrange */
        $activityPlan = ActivityPlan::create([
            'name'       => 'Delete Activity Plan',
            'is_active'  => true,
            'company_id' => $this->company->id,
            'creator_id' => $this->user->id,
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListActivityPlans::class)
            ->mountAction(TestAction::make('delete')->table($activityPlan))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('activity_plans', [
            'id' => $activityPlan->id,
        ]);
    }
}
