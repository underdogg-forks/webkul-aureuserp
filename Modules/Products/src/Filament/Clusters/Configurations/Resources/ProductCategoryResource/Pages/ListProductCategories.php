<?php

namespace Modules\Products\Filament\Clusters\Configurations\Resources\ProductCategoryResource\Pages;

use Modules\Products\Filament\Clusters\Configurations\Resources\ProductCategoryResource;
use Modules\Core\Filament\Resources\CategoryResource\Pages\ListCategories;

class ListProductCategories extends ListCategories
{
    protected static string $resource = ProductCategoryResource::class;
}
