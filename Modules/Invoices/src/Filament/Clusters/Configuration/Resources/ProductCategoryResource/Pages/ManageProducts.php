<?php

namespace Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages;

use Modules\Core\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages\ManageProducts as BaseManageProducts;
use Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ManageProducts extends BaseManageProducts
{
    use HasRecordNavigationTabs;

    protected static string $resource = ProductCategoryResource::class;
}
