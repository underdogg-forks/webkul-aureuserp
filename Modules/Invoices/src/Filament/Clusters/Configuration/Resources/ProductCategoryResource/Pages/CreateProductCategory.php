<?php

namespace Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages;

use Filament\Pages\Enums\SubNavigationPosition;
use Modules\Core\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages\CreateProductCategory as BaseCreateProductCategory;
use Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource;

class CreateProductCategory extends BaseCreateProductCategory
{
    protected static string $resource = ProductCategoryResource::class;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Start;

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }
}
