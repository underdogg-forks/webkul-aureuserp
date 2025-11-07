<?php

namespace Modules\Core\Filament\Resources\AccountTagResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Filament\Resources\AccountTagResource;

class ListAccountTags extends ListRecords
{
    protected static string $resource = AccountTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-o-plus-circle')
                ->mutateDataUsing(function (array $data): array {
                    $data['creator_id'] = Auth::user()->id;

                    return $data;
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('accounts::filament/resources/account-tag/pages/list-account-tag.header-actions.notification.title'))
                        ->body(__('accounts::filament/resources/account-tag/pages/list-account-tag.header-actions.notification.body'))
                ),
        ];
    }
}
