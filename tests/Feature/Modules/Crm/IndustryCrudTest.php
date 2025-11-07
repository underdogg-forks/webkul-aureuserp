<?php

namespace Tests\Feature\Modules\Crm;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Crm\Filament\Resources\IndustryResource\Pages\ManageIndustries;
use Modules\Crm\Models\Industry;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class IndustryCrudTest extends TestCase
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
    public function it_lists_industries(): void
    {
        /* Arrange */
        $visibleIndustry = Industry::factory()->create();
        $otherIndustry   = Industry::factory()->create();

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ManageIndustries::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$visibleIndustry])
            ->assertCanSeeTableRecords([$otherIndustry]);
    }

    #[Test]
    public function it_creates_an_industry(): void
    {
        /* Arrange */
        $payload = [
            'name'        => 'Industry ' . Str::random(5),
            'description' => 'Desc ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageIndustries::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('partners_industries', [
            'name'        => $payload['name'],
            'description' => $payload['description'],
        ]);
    }

    #[Test]
    public function it_updates_an_industry(): void
    {
        /* Arrange */
        $industry = Industry::factory()->create();

        $payload = [
            'name'        => 'Updated ' . $industry->name,
            'description' => 'Updated ' . $industry->description,
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageIndustries::class)
            ->mountAction(TestAction::make('edit')->table($industry), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('partners_industries', [
            'id'          => $industry->id,
            'name'        => $payload['name'],
            'description' => $payload['description'],
        ]);
    }

    #[Test]
    public function it_soft_deletes_an_industry(): void
    {
        /* Arrange */
        $industry = Industry::factory()->create();

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ManageIndustries::class)
            ->mountAction(TestAction::make('delete')->table($industry))
            ->callMountedAction();

        /* Assert */
        $this->assertSoftDeleted('partners_industries', [
            'id' => $industry->id,
        ]);
    }
}
