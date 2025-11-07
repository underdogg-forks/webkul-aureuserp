<?php

namespace Modules\Core\Filament\Clusters\Management\Resources\TimeOffResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Modules\Core\Filament\Actions as ChatterActions;
use Modules\Core\Filament\Clusters\Management\Resources\TimeOffResource;
use Modules\Core\Traits\TimeOffHelper;

class EditTimeOff extends EditRecord
{
    use TimeOffHelper;

    protected static string $resource = TimeOffResource::class;

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title(__('time-off::filament/clusters/management/resources/time-off/pages/edit-time-off.notification.title'))
            ->body(__('time-off::filament/clusters/management/resources/time-off/pages/edit-time-off.notification.body'));
    }

    protected function getHeaderActions(): array
    {
        return [
            ChatterActions\ChatterAction::make()
                ->setResource(static::$resource),
            ViewAction::make(),
            DeleteAction::make()
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('time-off::filament/clusters/management/resources/time-off/pages/edit-time-off.header-actions.delete.notification.title'))
                        ->body(__('time-off::filament/clusters/management/resources/time-off/pages/edit-time-off.header-actions.delete.notification.body'))
                ),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->mutateTimeOffData($data, $this->record?->id);
    }
}
