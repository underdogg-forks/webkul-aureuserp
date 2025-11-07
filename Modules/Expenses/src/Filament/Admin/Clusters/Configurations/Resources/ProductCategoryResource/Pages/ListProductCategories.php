<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductCategoryResource\Pages;

use Modules\Core\Filament\Resources\CategoryResource\Pages\ListCategories;
use Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductCategoryResource;

class ListProductCategories extends ListCategories
{
    protected static string $resource = ProductCategoryResource::class;
}
