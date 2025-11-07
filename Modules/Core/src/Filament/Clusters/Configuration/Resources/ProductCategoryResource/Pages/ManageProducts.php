<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages;

use Modules\Core\Filament\Clusters\Configuration\Resources\ProductCategoryResource;
use Modules\Core\Filament\Resources\CategoryResource\Pages\ManageProducts as BaseManageProducts;

class ManageProducts extends BaseManageProducts
{
    protected static string $resource = ProductCategoryResource::class;
}
