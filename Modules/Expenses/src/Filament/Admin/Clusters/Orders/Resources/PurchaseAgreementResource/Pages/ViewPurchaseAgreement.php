<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\PurchaseAgreementResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Modules\Core\Filament\Actions\ChatterAction;
use Modules\Expenses\Enums\RequisitionState;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\PurchaseAgreementResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ViewPurchaseAgreement extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = PurchaseAgreementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ChatterAction::make()
                ->setResource(static::$resource),
            DeleteAction::make()
                ->hidden(fn () => $this->getRecord()->state == RequisitionState::CLOSED)
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('inventories::filament/clusters/orders/resources/purchase-agreement/pages/view-purchase-agreement.header-actions.delete.notification.title'))
                        ->body(__('inventories::filament/clusters/orders/resources/purchase-agreement/pages/view-purchase-agreement.header-actions.delete.notification.body')),
                ),
        ];
    }
}
