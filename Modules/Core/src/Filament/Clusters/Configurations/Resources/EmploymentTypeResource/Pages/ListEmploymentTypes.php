<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources\EmploymentTypeResource\Pages;

use Modules\Core\Filament\Clusters\Configurations\Resources\EmploymentTypeResource\Pages\ListEmploymentTypes as BaseListEmploymentTypes;
use Modules\Core\Filament\Clusters\Configurations\Resources\EmploymentTypeResource;

class ListEmploymentTypes extends BaseListEmploymentTypes
{
    protected static string $resource = EmploymentTypeResource::class;
}
