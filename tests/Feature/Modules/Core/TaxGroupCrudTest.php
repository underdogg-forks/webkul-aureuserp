<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\TaxGroupResource\Pages\ListTaxGroups;
use Modules\Core\Models\TaxGroup;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class TaxGroupCrudTest extends TestCase
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
    public function it_lists_tax_groups(): void
    {
        /* Arrange */
        $taxGroup1 = TaxGroup::create([
            'name' => 'VAT Group',
        ]);

        $taxGroup2 = TaxGroup::create([
            'name' => 'Sales Tax Group',
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListTaxGroups::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$taxGroup1, $taxGroup2]);
    }

    #[Test]
    public function it_creates_a_tax_group(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Tax Group ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListTaxGroups::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_tax_groups', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_a_tax_group(): void
    {
        /* Arrange */
        $taxGroup = TaxGroup::create([
            'name' => 'Original Tax Group',
        ]);

        $payload = [
            'name' => 'Updated Tax Group',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListTaxGroups::class)
            ->mountAction(TestAction::make('edit')->table($taxGroup), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_tax_groups', [
            'id'   => $taxGroup->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_tax_group(): void
    {
        /* Arrange */
        $taxGroup = TaxGroup::create([
            'name' => 'Delete Tax Group',
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListTaxGroups::class)
            ->mountAction(TestAction::make('delete')->table($taxGroup))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('accounts_tax_groups', [
            'id' => $taxGroup->id,
        ]);
    }
}
