<?php

namespace Modules\Core\Filament\Resources\InvoiceResource\Actions;

use Filament\Actions\Action;
use Modules\Core\Enums\MoveState;
use Modules\Core\Facades\Account;
use Modules\Core\Models\Move;

class SetAsCheckedAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('Set as checked'))
            ->label(__('accounts::filament/resources/invoice/actions/set-as-checked-action.title'))
            ->color('gray')
            ->action(function (Move $record, $livewire): void {
                $record = Account::setAsChecked($record);

                $livewire->refreshFormData(['checked']);
            })
            ->hidden(function (Move $record) {
                return
                    $record->checked
                    || $record->state == MoveState::DRAFT;
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'customers.invoice.set-as-checked';
    }
}
