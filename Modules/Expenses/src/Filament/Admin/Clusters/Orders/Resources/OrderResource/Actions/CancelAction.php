<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Component;
use Modules\Core\Enums\MoveState;
use Modules\Expenses\Enums\OrderState;
use Modules\Expenses\Facades\PurchaseOrder;
use Modules\Expenses\Models\Order;

class CancelAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('purchases::filament/admin/clusters/orders/resources/order/actions/cancel.label'))
            ->color('gray')
            ->requiresConfirmation()
            ->action(function (Order $record, Component $livewire): void {
                $record->lines->each(function ($move) {
                    if ($move->qty_received > 0) {
                        Notification::make()
                            ->title(__('purchases::filament/admin/clusters/orders/resources/order/actions/cancel.action.notification.warning.receipts.title'))
                            ->body(__('purchases::filament/admin/clusters/orders/resources/order/actions/cancel.action.notification.warning.receipts.body'))
                            ->warning()
                            ->send();

                        return;
                    }
                });

                $record->accountMoves->each(function ($move) {
                    if ($move->state !== MoveState::CANCEL) {
                        Notification::make()
                            ->title(__('purchases::filament/admin/clusters/orders/resources/order/actions/cancel.action.notification.warning.bills.title'))
                            ->body(__('purchases::filament/admin/clusters/orders/resources/order/actions/cancel.action.notification.warning.bills.body'))
                            ->warning()
                            ->send();

                        return;
                    }
                });

                $record = PurchaseOrder::cancelPurchaseOrder($record);

                $livewire->updateForm();

                Notification::make()
                    ->title(__('purchases::filament/admin/clusters/orders/resources/order/actions/cancel.action.notification.success.title'))
                    ->body(__('purchases::filament/admin/clusters/orders/resources/order/actions/cancel.action.notification.success.body'))
                    ->success()
                    ->send();
            })
            ->visible(fn () => ! in_array($this->getRecord()->state, [
                OrderState::DONE,
                OrderState::CANCELED,
            ]));
    }

    public static function getDefaultName(): ?string
    {
        return 'purchases.orders.cancel';
    }
}
