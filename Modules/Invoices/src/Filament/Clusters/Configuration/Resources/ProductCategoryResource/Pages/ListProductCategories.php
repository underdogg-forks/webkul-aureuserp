<?php

namespace Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages;

use Modules\Core\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages\ListProductCategories as BaseListProductCategories;
use Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource;

class ListProductCategories extends BaseListProductCategories
{
    protected static string $resource = ProductCategoryResource::class;
}
