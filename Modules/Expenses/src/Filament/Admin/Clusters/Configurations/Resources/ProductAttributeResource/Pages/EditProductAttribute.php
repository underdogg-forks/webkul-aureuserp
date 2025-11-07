<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductAttributeResource\Pages;

use Modules\Core\Filament\Resources\AttributeResource\Pages\EditAttribute;
use Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductAttributeResource;

class EditProductAttribute extends EditAttribute
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
