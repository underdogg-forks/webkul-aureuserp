<?php

namespace Modules\Invoices\Filament\Clusters\Configuration\Resources\ActivityTypeResource\Pages;

use Modules\Invoices\Filament\Clusters\Configuration\Resources\ActivityTypeResource;
use Modules\Core\Filament\Resources\ActivityTypeResource\Pages\CreateActivityType as BaseCreateActivityType;

class CreateActivityType extends BaseCreateActivityType
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
