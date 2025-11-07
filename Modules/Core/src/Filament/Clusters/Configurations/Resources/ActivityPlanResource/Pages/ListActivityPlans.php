<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources\ActivityPlanResource\Pages;

use Modules\Core\Filament\Clusters\Configurations\Resources\ActivityPlanResource\Pages\ListActivityPlans as BaseListActivityPlans;
use Modules\Core\Filament\Clusters\Configurations\Resources\ActivityPlanResource;

class ListActivityPlans extends BaseListActivityPlans
{
    protected static string $resource = ActivityPlanResource::class;

    protected static ?string $pluginName = 'recruitments';
}
