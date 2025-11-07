<?php

namespace Modules\Invoices\Filament\Clusters\Orders\Resources\QuotationResource\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Invoices\Enums\OrderState;
use Modules\Invoices\Facades\SaleOrder;

class BackToQuotationAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('sales::filament/clusters/orders/resources/quotation/actions/back-to-quotation.title'))
            ->color('gray')
            ->hidden(fn ($record) => $record->state != OrderState::CANCEL)
            ->action(function ($record, $livewire) {
                SaleOrder::backToQuotation($record);

                $livewire->refreshFormData(['state']);

                Notification::make()
                    ->success()
                    ->title(__('sales::filament/clusters/orders/resources/quotation/actions/back-to-quotation.notification.back-to-quotation.title'))
                    ->body(__('sales::filament/clusters/orders/resources/quotation/actions/back-to-quotation.notification.back-to-quotation.body'))
                    ->send();
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'orders.sales.bak-to-quotation';
    }
}
