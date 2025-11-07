<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource\Pages;

use Modules\Core\Filament\Resources\ProductResource\Pages\ListProducts as BaseListProducts;
use Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource;

class ListProducts extends BaseListProducts
{
    protected static string $resource = ProductResource::class;
}
