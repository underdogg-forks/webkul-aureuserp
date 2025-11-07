<?php

namespace Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages;

use Modules\Core\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages\ViewProductCategory as BaseViewProductCategory;
use Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ViewProductCategory extends BaseViewProductCategory
{
    use HasRecordNavigationTabs;

    protected static string $resource = ProductCategoryResource::class;
}
