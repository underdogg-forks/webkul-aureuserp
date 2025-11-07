<?php

namespace Modules\Core\Filament\Clusters\Configurations\Resources\DepartmentResource\Pages;

use Modules\Core\Filament\Resources\DepartmentResource\Pages\CreateDepartment as BaseCreateDepartment;
use Modules\Core\Filament\Clusters\Configurations\Resources\DepartmentResource;

class CreateDepartment extends BaseCreateDepartment
{
    protected static string $resource = DepartmentResource::class;

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }
}
