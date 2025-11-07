<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages;

use Modules\Core\Filament\Clusters\Configuration\Resources\ProductCategoryResource;
use Modules\Core\Filament\Resources\CategoryResource\Pages\ListCategories;

class ListProductCategories extends ListCategories
{
    protected static string $resource = ProductCategoryResource::class;
}
