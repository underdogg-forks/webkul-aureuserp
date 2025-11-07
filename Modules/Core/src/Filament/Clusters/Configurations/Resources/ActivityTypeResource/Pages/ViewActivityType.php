<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources\ActivityTypeResource\Pages;

use Modules\Core\Filament\Resources\ActivityTypeResource\Pages\ViewActivityType as BaseViewActivityType;
use Modules\Core\Filament\Clusters\Configurations\Resources\ActivityTypeResource;

class ViewActivityType extends BaseViewActivityType
{
    protected static string $resource = ActivityTypeResource::class;

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }
}
