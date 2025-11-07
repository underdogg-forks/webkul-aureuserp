<?php

namespace Modules\Products\Filament\Clusters\Configurations\Resources\ProductCategoryResource\Pages;

use Modules\Products\Filament\Clusters\Configurations\Resources\ProductCategoryResource;
use Modules\Core\Filament\Resources\CategoryResource\Pages\ManageProducts as BaseManageProducts;

class ManageProducts extends BaseManageProducts
{
    protected static string $resource = ProductCategoryResource::class;
}
