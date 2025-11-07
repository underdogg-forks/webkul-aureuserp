<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductAttributeResource\Pages;

use Modules\Core\Filament\Resources\AttributeResource\Pages\ViewAttribute;
use Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductAttributeResource;

class ViewProductAttribute extends ViewAttribute
{
    protected static string $resource = ProductAttributeResource::class;

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }
}
