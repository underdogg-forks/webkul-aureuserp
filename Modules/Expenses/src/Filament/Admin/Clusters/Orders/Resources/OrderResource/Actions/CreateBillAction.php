<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Component;
use Modules\Expenses\Enums\OrderState;
use Modules\Expenses\Facades\PurchaseOrder;
use Modules\Expenses\Models\Order;

class CreateBillAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('purchases::filament/admin/clusters/orders/resources/order/actions/create-bill.label'))
            ->color(function (Order $record): string {
                if ($record->qty_to_invoice == 0) {
                    return 'gray';
                }

                return 'primary';
            })
            ->action(function (Order $record, Component $livewire): void {
                if ($record->qty_to_invoice == 0) {
                    Notification::make()
                        ->title(__('purchases::filament/admin/clusters/orders/resources/order/actions/create-bill.action.notification.warning.title'))
                        ->body(__('purchases::filament/admin/clusters/orders/resources/order/actions/create-bill.action.notification.warning.body'))
                        ->warning()
                        ->send();

                    return;
                }

                $record = PurchaseOrder::createPurchaseOrderBill($record);

                $livewire->updateForm();

                Notification::make()
                    ->title(__('purchases::filament/admin/clusters/orders/resources/order/actions/create-bill.action.notification.success.title'))
                    ->body(__('purchases::filament/admin/clusters/orders/resources/order/actions/create-bill.action.notification.success.body'))
                    ->success()
                    ->send();
            })
            ->visible(fn () => in_array($this->getRecord()->state, [
                OrderState::PURCHASE,
                OrderState::DONE,
            ]));
    }

    public static function getDefaultName(): ?string
    {
        return 'purchases.orders.create-bill';
    }
}
