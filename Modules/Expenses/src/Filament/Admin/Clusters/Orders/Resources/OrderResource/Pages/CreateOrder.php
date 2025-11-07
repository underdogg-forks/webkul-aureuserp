<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Modules\Expenses\Enums\OrderState;
use Modules\Expenses\Facades\PurchaseOrder;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource;
use Modules\Core\Concerns\HasRepeaterColumnManager;

class CreateOrder extends CreateRecord
{
    use HasRepeaterColumnManager;

    protected static string $resource = OrderResource::class;

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }

    protected function getCreatedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('purchases::filament/admin/clusters/orders/resources/order/pages/create-order.notification.title'))
            ->body(__('purchases::filament/admin/clusters/orders/resources/order/pages/create-order.notification.body'));
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['creator_id'] = Auth::id();

        $data['calendar_start_at'] = $data['ordered_at'];

        $data['state'] ??= OrderState::DRAFT;

        return $data;
    }

    protected function afterCreate(): void
    {
        PurchaseOrder::computePurchaseOrder($this->getRecord());
    }
}
