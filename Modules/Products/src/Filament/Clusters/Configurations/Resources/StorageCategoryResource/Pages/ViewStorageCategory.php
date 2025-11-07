<?php

namespace Modules\Products\Filament\Clusters\Configurations\Resources\StorageCategoryResource\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Modules\Products\Filament\Clusters\Configurations\Resources\StorageCategoryResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ViewStorageCategory extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = StorageCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
