<?php

namespace Modules\Products\Filament\Clusters\Configurations\Resources\ProductCategoryResource\Pages;

use Modules\Products\Filament\Clusters\Configurations\Resources\ProductCategoryResource;
use Modules\Core\Filament\Resources\CategoryResource\Pages\ViewCategory;

class ViewProductCategory extends ViewCategory
{
    protected static string $resource = ProductCategoryResource::class;
}
