<?php

namespace Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductAttributeResource\Pages;

use Modules\Core\Filament\Clusters\Configuration\Resources\ProductAttributeResource\Pages\CreateProductAttribute as BaseCreateProductAttribute;
use Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductAttributeResource;

class CreateProductAttribute extends BaseCreateProductAttribute
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
