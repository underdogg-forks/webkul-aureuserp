<?php

namespace Modules\Core\Filament\Clusters\Reporting\Resources\ByEmployeeResource\Pages;

use Modules\Core\Filament\Clusters\Management\Resources\TimeOffResource\Pages\ViewTimeOff as BaseViewTimeOff;
use Modules\Core\Filament\Clusters\Reporting\Resources\ByEmployeeResource;

class ViewByEmployee extends BaseViewTimeOff
{
    protected static string $resource = ByEmployeeResource::class;
}
