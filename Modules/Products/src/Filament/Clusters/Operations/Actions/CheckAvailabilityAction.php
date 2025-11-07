<?php

namespace Modules\Products\Filament\Clusters\Operations\Actions;

use Filament\Actions\Action;
use Livewire\Component;
use Modules\Products\Enums\MoveState;
use Modules\Products\Enums\OperationState;
use Modules\Products\Facades\Inventory;
use Modules\Products\Models\Operation;

class CheckAvailabilityAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('inventories::filament/clusters/operations/actions/check-availability.label'))
            ->action(function (Operation $record, Component $livewire): void {
                $record = Inventory::checkTransferAvailability($record);

                $livewire->updateForm();
            })
            ->hidden(function () {
                if ( ! in_array($this->getRecord()->state, [OperationState::CONFIRMED, OperationState::ASSIGNED])) {
                    return true;
                }

                return ! $this->getRecord()->moves->contains(fn ($move) => in_array($move->state, [MoveState::CONFIRMED, MoveState::PARTIALLY_ASSIGNED]));
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'inventories.operations.check_availability';
    }
}
