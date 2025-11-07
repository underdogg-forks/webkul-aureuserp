<?php

namespace Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductAttributeResource\Pages;

use Modules\Core\Filament\Clusters\Configuration\Resources\ProductAttributeResource\Pages\ViewProductAttribute as BaseViewProductAttribute;
use Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductAttributeResource;

class ViewProductAttribute extends BaseViewProductAttribute
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
