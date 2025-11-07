<?php

namespace Modules\Products\Filament\Clusters\Configurations\Resources\RouteResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Modules\Products\Filament\Clusters\Configurations\Resources\RouteResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class EditRoute extends EditRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = RouteResource::class;

    protected function getSavedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('inventories::filament/clusters/configurations/resources/route/pages/edit-route.notification.title'))
            ->body(__('inventories::filament/clusters/configurations/resources/route/pages/edit-route.notification.body'));
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('inventories::filament/clusters/configurations/resources/route/pages/edit-route.header-actions.delete.notification.title'))
                        ->body(__('inventories::filament/clusters/configurations/resources/route/pages/edit-route.header-actions.delete.notification.body')),
                ),
        ];
    }
}
