<?php

namespace Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages;

use Modules\Core\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages\EditProductCategory as BaseEditProductCategory;
use Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class EditProductCategory extends BaseEditProductCategory
{
    use HasRecordNavigationTabs;

    protected static string $resource = ProductCategoryResource::class;
}
