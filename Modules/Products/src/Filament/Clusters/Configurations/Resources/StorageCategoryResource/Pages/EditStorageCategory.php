<?php

namespace Modules\Products\Filament\Clusters\Configurations\Resources\StorageCategoryResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Modules\Products\Filament\Clusters\Configurations\Resources\StorageCategoryResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class EditStorageCategory extends EditRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = StorageCategoryResource::class;

    protected function getSavedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('inventories::filament/clusters/configurations/resources/storage-category/pages/edit-storage-category.notification.title'))
            ->body(__('inventories::filament/clusters/configurations/resources/storage-category/pages/edit-storage-category.notification.body'));
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('inventories::filament/clusters/configurations/resources/storage-category/pages/edit-storage-category.header-actions.delete.notification.title'))
                        ->body(__('inventories::filament/clusters/configurations/resources/storage-category/pages/edit-storage-category.header-actions.delete.notification.body')),
                ),
        ];
    }
}
