<?php

namespace Modules\Invoices\Filament\Clusters\Orders\Resources\QuotationResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Modules\Core\Filament\Actions as ChatterActions;
use Modules\Invoices\Enums\OrderState;
use Modules\Invoices\Filament\Clusters\Orders\Resources\QuotationResource;
use Modules\Invoices\Filament\Clusters\Orders\Resources\QuotationResource\Actions as BaseActions;
use Modules\Core\Concerns\HasRepeatableEntryColumnManager;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ViewQuotation extends ViewRecord
{
    use HasRecordNavigationTabs;
    use HasRepeatableEntryColumnManager;

    protected static string $resource = QuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ChatterActions\ChatterAction::make()
                ->setResource($this->getResource()),
            BaseActions\BackToQuotationAction::make(),
            BaseActions\CancelQuotationAction::make(),
            BaseActions\ConfirmAction::make(),
            BaseActions\CreateInvoiceAction::make(),
            BaseActions\PreviewAction::make(),
            BaseActions\SendByEmailAction::make(),
            BaseActions\LockAndUnlockAction::make(),
            DeleteAction::make()
                ->hidden(fn () => $this->getRecord()->state == OrderState::SALE)
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('sales::filament/clusters/orders/resources/quotation/pages/view-quotation.header-actions.notification.delete.title'))
                        ->body(__('sales::filament/clusters/orders/resources/quotation/pages/view-quotation.header-actions.notification.delete.body')),
                ),
        ];
    }
}
