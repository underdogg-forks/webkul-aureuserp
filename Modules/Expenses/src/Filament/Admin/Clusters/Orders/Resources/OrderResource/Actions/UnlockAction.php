<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Component;
use Modules\Expenses\Enums\OrderState;
use Modules\Expenses\Facades\PurchaseOrder;
use Modules\Expenses\Models\Order;

class UnlockAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('purchases::filament/admin/clusters/orders/resources/order/actions/unlock.label'))
            ->color('gray')
            ->action(function (Order $record, Component $livewire): void {
                $record = PurchaseOrder::unlockPurchaseOrder($record);

                $livewire->updateForm();

                Notification::make()
                    ->title(__('purchases::filament/admin/clusters/orders/resources/order/actions/unlock.action.notification.success.title'))
                    ->body(__('purchases::filament/admin/clusters/orders/resources/order/actions/unlock.action.notification.success.body'))
                    ->success()
                    ->send();
            })
            ->visible(fn () => $this->getRecord()->state === OrderState::DONE);
    }

    public static function getDefaultName(): ?string
    {
        return 'purchases.orders.unlock';
    }
}
