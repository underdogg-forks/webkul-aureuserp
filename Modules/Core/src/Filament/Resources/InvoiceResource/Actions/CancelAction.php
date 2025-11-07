<?php

namespace Modules\Core\Filament\Resources\InvoiceResource\Actions;

use Filament\Actions\Action;
use Livewire\Component;
use Modules\Core\Enums\MoveState;
use Modules\Core\Enums\MoveType;
use Modules\Core\Facades\Account;
use Modules\Core\Models\Move;

class CancelAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('accounts::filament/resources/invoice/actions/cancel-action.title'))
            ->color('gray')
            ->action(function (Move $record, Component $livewire): void {
                $record = Account::cancel($record);

                $livewire->refreshFormData(['state', 'parent_state']);
            })
            ->hidden(function (Move $record) {
                return
                    $record->state != MoveState::DRAFT
                    || $record->move_type == MoveType::ENTRY;
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'customers.invoice.cancel';
    }
}
