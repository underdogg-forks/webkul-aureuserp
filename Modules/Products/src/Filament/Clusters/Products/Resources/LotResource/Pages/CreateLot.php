<?php

namespace Modules\Products\Filament\Clusters\Products\Resources\LotResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Products\Filament\Clusters\Products\Resources\LotResource;

class CreateLot extends CreateRecord
{
    protected static string $resource = LotResource::class;

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }
}
