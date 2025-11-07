<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductCategoryResource\Pages;

use Modules\Core\Filament\Resources\CategoryResource\Pages\ManageProducts as BaseManageProducts;
use Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductCategoryResource;

class ManageProducts extends BaseManageProducts
{
    protected static string $resource = ProductCategoryResource::class;
}
