<?php

namespace Modules\Core\Filament\Resources\BillResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Modules\Core\Filament\Resources\BillResource;
use Modules\Core\Filament\Resources\BillResource\Actions\CreditNoteAction;
use Modules\Core\Filament\Resources\InvoiceResource\Actions as BaseActions;
use Modules\Core\Filament\Actions as ChatterActions;
use Modules\Core\Concerns\HasRepeatableEntryColumnManager;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ViewBill extends ViewRecord
{
    use HasRecordNavigationTabs;
    use HasRepeatableEntryColumnManager;

    protected static string $resource = BillResource::class;

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
            CreditNoteAction::make(),
            DeleteAction::make()
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('accounts::filament/resources/bill/pages/view-bill.header-actions.delete.notification.title'))
                        ->body(__('accounts::filament/resources/bill/pages/view-bill.header-actions.delete.notification.body'))
                ),
        ];
    }
}
