<?php

namespace Modules\Core\Filament\Resources\CompanyResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Modules\Core\Filament\Resources\CompanyResource;
use Modules\Core\Models\User;

class ViewCompany extends ViewRecord
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make()
                ->hidden(fn () => User::where('default_company_id', $this->record->id)->exists())
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('security::filament/resources/company/pages/view-company.header-actions.delete.notification.title'))
                        ->body(__('security::filament/resources/company/pages/view-company.header-actions.delete.notification.body'))
                ),
        ];
    }
}
