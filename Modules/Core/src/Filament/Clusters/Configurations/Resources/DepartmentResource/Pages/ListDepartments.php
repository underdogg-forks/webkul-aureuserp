<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources\DepartmentResource\Pages;

use Modules\Core\Filament\Resources\DepartmentResource\Pages\ListDepartments as BaseListDepartments;
use Modules\Core\Filament\Clusters\Configurations\Resources\DepartmentResource;

class ListDepartments extends BaseListDepartments
{
    protected static string $resource = DepartmentResource::class;
}
