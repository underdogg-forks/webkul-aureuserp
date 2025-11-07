<?php

namespace Modules\Invoices\Filament\Clusters\Configuration\Resources\ActivityTypeResource\Pages;

use Modules\Invoices\Filament\Clusters\Configuration\Resources\ActivityTypeResource;
use Modules\Core\Filament\Resources\ActivityTypeResource\Pages\ListActivityTypes as BaseListActivityTypes;

class ListActivityTypes extends BaseListActivityTypes
{
    protected static string $resource = ActivityTypeResource::class;
}
