<?php

namespace Modules\Core\Filament\Resources\UserResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Modules\Core\Filament\Resources\UserResource;
use Modules\Core\Models\User;

class ViewUsers extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make()
                ->visible(fn (User $record) => self::getResource()::canDeleteUser($record))
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('security::filament/resources/user/pages/view-user.header-actions.delete.notification.title'))
                        ->body(__('security::filament/resources/user/pages/view-user.header-actions.delete.notification.body')),
                ),
        ];
    }
}
