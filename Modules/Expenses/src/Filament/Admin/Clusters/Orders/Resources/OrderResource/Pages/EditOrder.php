<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\QueryException;
use Modules\Core\Filament\Actions\ChatterAction;
use Modules\Expenses\Enums\OrderState;
use Modules\Expenses\Facades\PurchaseOrder;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\OrderResource\Actions as OrderActions;
use Modules\Expenses\Models\Order;
use Modules\Core\Concerns\HasRepeaterColumnManager;
use Modules\Core\Traits\HasRecordNavigationTabs;

class EditOrder extends EditRecord
{
    use HasRecordNavigationTabs;
    use HasRepeaterColumnManager;

    protected static string $resource = OrderResource::class;

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
            ->title(__('purchases::filament/admin/clusters/orders/resources/order/pages/edit-order.notification.title'))
            ->body(__('purchases::filament/admin/clusters/orders/resources/order/pages/edit-order.notification.body'));
    }

    protected function configureAction(Action $action): void
    {
        if ($action instanceof ChatterAction) {
            $order = Order::find($this->getRecord()->id);

            $action
                ->record($order)
                ->recordTitle($this->getRecordTitle());

            return;
        }

        parent::configureAction($action);
    }

    protected function getHeaderActions(): array
    {
        return [
            ChatterAction::make()
                ->record(\Modules\Expenses\Models\Order::find($this->getRecord()->id))
                ->setResource(self::$resource),
            OrderActions\SendEmailAction::make(),
            OrderActions\SendPOEmailAction::make(),
            OrderActions\PrintRFQAction::make(),
            OrderActions\DraftAction::make(),
            OrderActions\ConfirmAction::make(),
            OrderActions\ConfirmReceiptDateAction::make(),
            OrderActions\CreateBillAction::make(),
            OrderActions\LockAction::make(),
            OrderActions\UnlockAction::make(),
            OrderActions\CancelAction::make(),
            DeleteAction::make()
                ->hidden(fn () => $this->getRecord()->state == OrderState::DONE)
                ->action(function (DeleteAction $action, Order $record) {
                    try {
                        $record->delete();

                        $action->success();
                    } catch (QueryException $e) {
                        Notification::make()
                            ->danger()
                            ->title(__('purchases::filament/admin/clusters/orders/resources/order/pages/edit-order.header-actions.delete.notification.error.title'))
                            ->body(__('purchases::filament/admin/clusters/orders/resources/order/pages/edit-order.header-actions.delete.notification.error.body'))
                            ->send();

                        $action->failure();
                    }
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('purchases::filament/admin/clusters/orders/resources/order/pages/edit-order.header-actions.delete.notification.success.title'))
                        ->body(__('purchases::filament/admin/clusters/orders/resources/order/pages/edit-order.header-actions.delete.notification.success.body')),
                ),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ( ! empty($data['ordered_at'])) {
            $data['calendar_start_at'] = $data['ordered_at'];
        }

        return $data;
    }

    protected function afterSave(): void
    {
        PurchaseOrder::computePurchaseOrder($this->getRecord());
    }
}
