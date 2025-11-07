<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources\DepartmentResource\Pages;

use Modules\Core\Filament\Resources\DepartmentResource\Pages\ViewDepartment as BaseViewDepartment;
use Modules\Core\Filament\Clusters\Configurations\Resources\DepartmentResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ViewDepartment extends BaseViewDepartment
{
    use HasRecordNavigationTabs;

    protected static string $resource = DepartmentResource::class;
}
