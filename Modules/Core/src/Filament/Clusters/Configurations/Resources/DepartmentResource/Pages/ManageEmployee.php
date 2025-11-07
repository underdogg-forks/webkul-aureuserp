<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources\DepartmentResource\Pages;

use Modules\Core\Filament\Resources\DepartmentResource\Pages\ManageEmployee as BaseManageEmployee;
use Modules\Core\Filament\Clusters\Configurations\Resources\DepartmentResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ManageEmployee extends BaseManageEmployee
{
    use HasRecordNavigationTabs;

    protected static string $resource = DepartmentResource::class;
}
