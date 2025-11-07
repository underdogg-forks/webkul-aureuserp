<?php

namespace Modules\Core\Filament\Resources\ActivityTypeResource\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Modules\Core\Filament\Resources\ActivityTypeResource;

class CreateActivityType extends CreateRecord
{
    protected static string $resource = ActivityTypeResource::class;

    protected static ?string $pluginName = 'support';

    protected static function getPluginName()
    {
        return static::$pluginName;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getCreatedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('support::filament/resources/activity-type/pages/create-activity-type.notification.title'))
            ->body(__('support::filament/resources/activity-type/pages/create-activity-type.notification.body'));
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['plugin'] = static::getPluginName();

        return $data;
    }
}
