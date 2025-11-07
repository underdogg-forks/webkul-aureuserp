<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources\ActivityTypeResource\Pages;

use Modules\Core\Filament\Resources\ActivityTypeResource\Pages\EditActivityType as BaseEditActivityType;
use Modules\Core\Filament\Clusters\Configurations\Resources\ActivityTypeResource;

class EditActivityType extends BaseEditActivityType
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
