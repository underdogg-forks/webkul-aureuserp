<?php

namespace Modules\Products\Filament\Clusters\Operations\Actions;

use Filament\Actions\Action;
use Livewire\Component;
use Modules\Products\Enums\OperationState;
use Modules\Products\Facades\Inventory;
use Modules\Products\Filament\Clusters\Operations\Resources\OperationResource;
use Modules\Products\Models\Operation;

class ReturnAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('inventories::filament/clusters/operations/actions/return.label'))
            ->color('gray')
            ->requiresConfirmation()
            ->action(function (Operation $record, Component $livewire) {
                $newRecord = Inventory::returnTransfer($record);

                $livewire->updateForm();

                return redirect()->to(OperationResource::getUrl('edit', ['record' => $newRecord]));
            })
            ->visible(fn () => $this->getRecord()->state == OperationState::DONE);
    }

    public static function getDefaultName(): ?string
    {
        return 'inventories.operations.return';
    }
}
