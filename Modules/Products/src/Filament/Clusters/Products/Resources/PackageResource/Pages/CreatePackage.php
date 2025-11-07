<?php

namespace Modules\Products\Filament\Clusters\Products\Resources\PackageResource\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Modules\Products\Filament\Clusters\Products\Resources\PackageResource;

class CreatePackage extends CreateRecord
{
    protected static string $resource = PackageResource::class;

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

    protected function getCreatedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('inventories::filament/clusters/products/resources/package/pages/create-package.notification.title'))
            ->body(__('inventories::filament/clusters/products/resources/package/pages/create-package.notification.body'));
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['creator_id'] = Auth::id();

        $data['company_id'] = Auth::user()->default_company_id;

        return $data;
    }
}
