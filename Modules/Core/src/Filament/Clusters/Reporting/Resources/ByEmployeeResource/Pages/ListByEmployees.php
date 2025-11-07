<?php

namespace Modules\Core\Filament\Clusters\Reporting\Resources\ByEmployeeResource\Pages;

use Modules\Core\Filament\Clusters\Management\Resources\TimeOffResource\Pages\ListTimeOff;
use Modules\Core\Filament\Clusters\Reporting\Resources\ByEmployeeResource;

class ListByEmployees extends ListTimeOff
{
    protected static string $resource = ByEmployeeResource::class;
}
