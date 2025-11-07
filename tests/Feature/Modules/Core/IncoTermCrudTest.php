<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\IncoTermResource\Pages\ListIncoTerms;
use Modules\Core\Models\IncoTerm;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class IncoTermCrudTest extends TestCase
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
    public function it_lists_inco_terms(): void
    {
        /* Arrange */
        $term1 = IncoTerm::create([
            'name' => 'FOB',
            'code' => 'FOB',
        ]);

        $term2 = IncoTerm::create([
            'name' => 'CIF',
            'code' => 'CIF',
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListIncoTerms::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$term1, $term2]);
    }

    #[Test]
    public function it_creates_an_inco_term(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'EXW ' . Str::random(3),
            'code' => 'EXW',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListIncoTerms::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_incoterms', [
            'name' => $payload['name'],
            'code' => $payload['code'],
        ]);
    }

    #[Test]
    public function it_updates_an_inco_term(): void
    {
        /* Arrange */
        $term = IncoTerm::create([
            'name' => 'Original Term',
            'code' => 'OT',
        ]);

        $payload = [
            'name' => 'Updated Term',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListIncoTerms::class)
            ->mountAction(TestAction::make('edit')->table($term), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_incoterms', [
            'id'   => $term->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_an_inco_term(): void
    {
        /* Arrange */
        $term = IncoTerm::create([
            'name' => 'Delete Term',
            'code' => 'DT',
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListIncoTerms::class)
            ->mountAction(TestAction::make('delete')->table($term))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('accounts_incoterms', [
            'id' => $term->id,
        ]);
    }
}
