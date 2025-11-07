<?php

namespace Modules\Core\Filament\Resources\InvoiceResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Modules\Core\Filament\Resources\InvoiceResource;
use Modules\Core\Filament\Resources\InvoiceResource\Actions as BaseActions;
use Modules\Core\Filament\Actions as ChatterActions;
use Modules\Core\Concerns\HasRepeatableEntryColumnManager;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ViewInvoice extends ViewRecord
{
    use HasRecordNavigationTabs;
    use HasRepeatableEntryColumnManager;

    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ChatterActions\ChatterAction::make()
                ->setResource($this->getResource()),
            BaseActions\PayAction::make(),
            BaseActions\ConfirmAction::make(),
            BaseActions\CancelAction::make(),
            BaseActions\ResetToDraftAction::make(),
            BaseActions\SetAsCheckedAction::make(),
            BaseActions\PreviewAction::make()
                ->setTemplate('accounts::invoice/actions/preview.index'),
            BaseActions\PrintAndSendAction::make(),
            BaseActions\CreditNoteAction::make(),
            DeleteAction::make()
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('accounts::filament/resources/invoice/pages/view-invoice.header-actions.delete.notification.title'))
                        ->body(__('accounts::filament/resources/invoice/pages/view-invoice.header-actions.delete.notification.body'))
                ),
        ];
    }
}
