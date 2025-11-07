<?php

namespace Modules\Invoices\Filament\Clusters\Configuration\Resources\ActivityTypeResource\Pages;

use Modules\Invoices\Filament\Clusters\Configuration\Resources\ActivityTypeResource;
use Modules\Core\Filament\Resources\ActivityTypeResource\Pages\EditActivityType as BaseEditActivityType;

class EditActivityType extends BaseEditActivityType
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
