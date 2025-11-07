<?php

namespace Modules\Products\Filament\Clusters\Configurations\Resources\ProductAttributeResource\Pages;

use Modules\Products\Filament\Clusters\Configurations\Resources\ProductAttributeResource;
use Modules\Core\Filament\Resources\AttributeResource\Pages\CreateAttribute;

class CreateProductAttribute extends CreateAttribute
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
