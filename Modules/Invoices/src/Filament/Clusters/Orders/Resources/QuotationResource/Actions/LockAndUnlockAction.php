<?php

namespace Modules\Invoices\Filament\Clusters\Orders\Resources\QuotationResource\Actions;

use Filament\Actions\Action;
use Modules\Invoices\Facades\SaleOrder;
use Modules\Invoices\Models\Order;
use Modules\Invoices\Settings\QuotationAndOrderSettings;

class LockAndUnlockAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn ($record) => $record->locked ? __('sales::filament/clusters/orders/resources/quotation/actions/lock-and-unlock.unlock') : __('sales::filament/clusters/orders/resources/quotation/actions/lock-and-unlock.lock'))
            ->color(fn ($record) => $record->locked ? 'primary' : 'gray')
            ->icon(fn ($record) => ! $record->locked ? 'heroicon-o-lock-closed' : 'heroicon-o-lock-open')
            ->action(function (Order $record): void {
                SaleOrder::lockAndUnlock($record);
            })
            ->visible(fn (QuotationAndOrderSettings $quotationAndOrderSettings) => $quotationAndOrderSettings?->enable_lock_confirm_sales);
    }

    public static function getDefaultName(): ?string
    {
        return 'purchases.orders.lock';
    }
}
