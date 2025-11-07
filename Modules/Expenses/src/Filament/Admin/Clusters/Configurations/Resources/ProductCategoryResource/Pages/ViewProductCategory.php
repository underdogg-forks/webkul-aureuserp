<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductCategoryResource\Pages;

use Modules\Core\Filament\Resources\CategoryResource\Pages\ViewCategory;
use Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductCategoryResource;

class ViewProductCategory extends ViewCategory
{
    protected static string $resource = ProductCategoryResource::class;
}
