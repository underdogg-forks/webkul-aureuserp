<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources\ActivityTypeResource\Pages;

use Modules\Core\Filament\Resources\ActivityTypeResource\Pages\CreateActivityType as BaseCreateActivityType;
use Modules\Core\Filament\Clusters\Configurations\Resources\ActivityTypeResource;

class CreateActivityType extends BaseCreateActivityType
{
    protected static string $resource = ActivityTypeResource::class;

    protected static ?string $pluginName = 'time-off';

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }
}
