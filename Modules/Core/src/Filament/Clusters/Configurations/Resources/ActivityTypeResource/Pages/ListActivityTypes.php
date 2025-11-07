<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources\ActivityTypeResource\Pages;

use Modules\Core\Filament\Resources\ActivityTypeResource\Pages\ListActivityTypes as BaseListActivityTypes;
use Modules\Core\Filament\Clusters\Configurations\Resources\ActivityTypeResource;

class ListActivityTypes extends BaseListActivityTypes
{
    protected static string $resource = ActivityTypeResource::class;

    protected static ?string $pluginName = 'time-off';
}
