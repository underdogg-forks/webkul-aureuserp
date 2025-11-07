<?php

namespace Modules\Core\Filament\Resources\CreditNoteResource\Pages;

use Filament\Notifications\Notification;
use Modules\Core\Enums\MoveType;
use Modules\Core\Facades\Account;
use Modules\Core\Filament\Resources\CreditNoteResource;
use Modules\Core\Filament\Resources\InvoiceResource\Pages\CreateInvoice as CreateRecord;

class CreateCreditNote extends CreateRecord
{
    protected static string $resource = CreditNoteResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title(__('accounts::filament/resources/credit-note/pages/create-credit-note.notification.title'))
            ->body(__('accounts::filament/resources/credit-note/pages/create-credit-note.notification.body'));
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['move_type'] ??= MoveType::OUT_REFUND;

        $data['date'] = now();

        return $data;
    }

    protected function afterCreate(): void
    {
        Account::computeAccountMove($this->getRecord());
    }
}
