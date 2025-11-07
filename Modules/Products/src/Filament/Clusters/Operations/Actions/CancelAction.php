<?php

namespace Modules\Products\Filament\Clusters\Operations\Actions;

use Filament\Actions\Action;
use Livewire\Component;
use Modules\Products\Enums\OperationState;
use Modules\Products\Facades\Inventory;
use Modules\Products\Models\Operation;

class CancelAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('inventories::filament/clusters/operations/actions/cancel.label'))
            ->color('gray')
            ->action(function (Operation $record, Component $livewire): void {
                $record = Inventory::cancelTransfer($record);

                $livewire->updateForm();
            })
            ->visible(fn () => ! in_array($this->getRecord()->state, [
                OperationState::DONE,
                OperationState::CANCELED,
            ]));
    }

    public static function getDefaultName(): ?string
    {
        return 'inventories.operations.cancel';
    }
}
