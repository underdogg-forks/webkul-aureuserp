<?php

namespace Modules\Core\Filament\Resources\RefundResource\Pages;

use Filament\Notifications\Notification;
use Modules\Core\Enums\MoveType;
use Modules\Core\Facades\Account;
use Modules\Core\Filament\Resources\InvoiceResource\Pages\CreateInvoice as CreateBaseRefund;
use Modules\Core\Filament\Resources\RefundResource;

class CreateRefund extends CreateBaseRefund
{
    protected static string $resource = RefundResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title(__('accounts::filament/resources/refund/pages/create-refund.notification.title'))
            ->body(__('accounts::filament/resources/refund/pages/create-refund.notification.body'));
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['move_type'] ??= MoveType::IN_REFUND;

        $data['date'] = now();

        return $data;
    }

    protected function afterCreate(): void
    {
        Account::computeAccountMove($this->getRecord());
    }
}
