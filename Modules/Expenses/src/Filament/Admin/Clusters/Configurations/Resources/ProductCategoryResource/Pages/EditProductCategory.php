<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductCategoryResource\Pages;

use Modules\Core\Filament\Resources\CategoryResource\Pages\EditCategory;
use Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductCategoryResource;

class EditProductCategory extends EditCategory
{
    protected static string $resource = ProductCategoryResource::class;
}
