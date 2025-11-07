<?php

namespace Tests\Feature\Modules\Core;

use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Core\Filament\Resources\PaymentTermResource\Pages\ListPaymentTerms;
use Modules\Core\Models\PaymentTerm;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @group smoke
 */
class PaymentTermCrudTest extends TestCase
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
    public function it_lists_payment_terms(): void
    {
        /* Arrange */
        $term1 = PaymentTerm::create([
            'name' => 'Net 30',
        ]);

        $term2 = PaymentTerm::create([
            'name' => 'Net 60',
        ]);

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test(ListPaymentTerms::class);

        /* Assert */
        $component->assertCanSeeTableRecords([$term1, $term2]);
    }

    #[Test]
    public function it_creates_a_payment_term(): void
    {
        /* Arrange */
        $payload = [
            'name' => 'New Payment Term ' . Str::random(5),
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPaymentTerms::class)
            ->mountAction('create')
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_payment_terms', [
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_updates_a_payment_term(): void
    {
        /* Arrange */
        $term = PaymentTerm::create([
            'name' => 'Original Payment Term',
        ]);

        $payload = [
            'name' => 'Updated Payment Term',
        ];

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPaymentTerms::class)
            ->mountAction(TestAction::make('edit')->table($term), $payload)
            ->fillForm($payload)
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseHas('accounts_payment_terms', [
            'id'   => $term->id,
            'name' => $payload['name'],
        ]);
    }

    #[Test]
    public function it_deletes_a_payment_term(): void
    {
        /* Arrange */
        $term = PaymentTerm::create([
            'name' => 'Delete Payment Term',
        ]);

        /* Act */
        Livewire::actingAs($this->user)
            ->test(ListPaymentTerms::class)
            ->mountAction(TestAction::make('delete')->table($term))
            ->callMountedAction();

        /* Assert */
        $this->assertDatabaseMissing('accounts_payment_terms', [
            'id' => $term->id,
        ]);
    }
}
