<?php

namespace Modules\Products\Filament\Clusters\Operations\Resources\DeliveryResource\Pages;

use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\QueryException;
use Modules\Core\Filament\Actions\ChatterAction;
use Modules\Products\Enums\OperationState;
use Modules\Products\Filament\Clusters\Operations\Actions as OperationActions;
use Modules\Products\Filament\Clusters\Operations\Resources\DeliveryResource;
use Modules\Products\Models\Delivery;
use Modules\Core\Traits\HasRecordNavigationTabs;

class EditDelivery extends EditRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = DeliveryResource::class;

    public function updateForm(): void
    {
        $this->fillForm();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }

    protected function getSavedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('inventories::filament/clusters/operations/resources/delivery/pages/edit-delivery.notification.title'))
            ->body(__('inventories::filament/clusters/operations/resources/delivery/pages/edit-delivery.notification.body'));
    }

    protected function getHeaderActions(): array
    {
        return [
            ChatterAction::make()
                ->setResource(static::$resource),
            OperationActions\TodoAction::make(),
            OperationActions\CheckAvailabilityAction::make(),
            OperationActions\ValidateAction::make(),
            OperationActions\CancelAction::make(),
            OperationActions\ReturnAction::make(),
            ActionGroup::make([
                OperationActions\Print\PickingOperationAction::make(),
                OperationActions\Print\DeliverySlipAction::make(),
                OperationActions\Print\PackageAction::make(),
                OperationActions\Print\LabelsAction::make(),
            ])
                ->label(__('inventories::filament/clusters/operations/resources/delivery/pages/edit-delivery.header-actions.print.label'))
                ->icon('heroicon-o-printer')
                ->color('gray')
                ->button(),
            DeleteAction::make()
                ->hidden(fn () => $this->getRecord()->state == OperationState::DONE)
                ->action(function (DeleteAction $action, Delivery $record) {
                    try {
                        $record->delete();

                        $action->success();
                    } catch (QueryException $e) {
                        Notification::make()
                            ->danger()
                            ->title(__('inventories::filament/clusters/operations/resources/delivery/pages/edit-delivery.header-actions.delete.notification.error.title'))
                            ->body(__('inventories::filament/clusters/operations/resources/delivery/pages/edit-delivery.header-actions.delete.notification.error.body'))
                            ->send();

                        $action->failure();
                    }
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('inventories::filament/clusters/operations/resources/delivery/pages/edit-delivery.header-actions.delete.notification.success.title'))
                        ->body(__('inventories::filament/clusters/operations/resources/delivery/pages/edit-delivery.header-actions.delete.notification.success.body')),
                ),
        ];
    }
}
