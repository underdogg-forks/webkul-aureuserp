<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources\DepartmentResource\Pages;

use Modules\Core\Filament\Resources\DepartmentResource\Pages\EditDepartment as BaseEditDepartment;
use Modules\Core\Filament\Clusters\Configurations\Resources\DepartmentResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class EditDepartment extends BaseEditDepartment
{
    use HasRecordNavigationTabs;

    protected static string $resource = DepartmentResource::class;
}
