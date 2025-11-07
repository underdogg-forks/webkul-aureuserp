<?php

namespace Modules\Core\Filament\Clusters\MyTime\Resources\MyAllocationResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Core\Filament\Clusters\MyTime\Resources\MyAllocationResource;

class ListMyAllocations extends ListRecords
{
    protected static string $resource = MyAllocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
