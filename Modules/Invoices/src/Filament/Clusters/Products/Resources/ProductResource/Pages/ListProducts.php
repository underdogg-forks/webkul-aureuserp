<?php

namespace Modules\Invoices\Filament\Clusters\Products\Resources\ProductResource\Pages;

use Modules\Core\Filament\Clusters\Vendors\Resources\ProductResource\Pages\ListProducts as BaseListProducts;
use Modules\Invoices\Filament\Clusters\Products\Resources\ProductResource;

class ListProducts extends BaseListProducts
{
    protected static string $resource = ProductResource::class;
}
