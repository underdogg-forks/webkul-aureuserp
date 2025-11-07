<?php

namespace Tests\Feature\Modules\Projects;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Livewire\Livewire;
use Tests\TestCase;
use Webkul\Project\Filament\Resources\ProjectResource\Pages\ListProjects;
use Webkul\Project\Models\Project;

/**
 * @group smoke
 */
class ProjectListTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        Model::unguard();
        $this->user = User::factory()->create();
    }

    public function it_lists_my_projects(): void
    {
        /* Arrange */
        $mine    = Project::factory()->create(['user_id' => $this->user->id]);
        $notMine = Project::factory()->create(['user_id' => null]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListProjects::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$mine])
            ->assertCanNotSeeTableRecords([$notMine]);
    }
}
