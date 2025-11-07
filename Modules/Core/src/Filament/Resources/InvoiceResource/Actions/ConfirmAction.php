<?php

namespace Modules\Core\Filament\Resources\InvoiceResource\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Component;
use Modules\Core\Enums\AutoPost;
use Modules\Core\Enums\MoveState;
use Modules\Core\Facades\Account;
use Modules\Core\Models\Move;

class ConfirmAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('accounts::filament/resources/invoice/actions/confirm-action.title'))
            ->color('gray')
            ->action(function (Move $record, Component $livewire): void {
                if ( ! $this->validateMove($record)) {
                    return;
                }

                $record = Account::confirm($record);

                $livewire->refreshFormData(['state', 'parent_state']);
            })
            ->hidden(function (Move $record) {
                return
                    $record->state !== MoveState::DRAFT
                    || ($record->auto_post !== AutoPost::NO && $record->date > now());
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'customers.invoice.confirm';
    }

    private function validateMove(Move $record): bool
    {
        if ( ! $record->partner_id) {
            Notification::make()
                ->warning()
                ->title(__('accounts::filament/resources/invoice/actions/confirm-action.customer.notification.customer-validation.title'))
                ->body(__('accounts::filament/resources/invoice/actions/confirm-action.customer.notification.customer-validation.body'))
                ->send();

            return false;
        }

        if ($record->lines->isEmpty()) {
            Notification::make()
                ->warning()
                ->title(__('Move Line validation'))
                ->body(__('Please add at least one line to the invoice.'))

                ->title(__('accounts::filament/resources/invoice/actions/confirm-action.customer.notification.move-line-validation.title'))
                ->body(__('accounts::filament/resources/invoice/actions/confirm-action.customer.notification.move-line-validation.body'))
                ->send();

            return false;
        }

        return true;
    }
}
