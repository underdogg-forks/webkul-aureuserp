<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\ProductResource\Pages;

use Modules\Core\Filament\Clusters\Customer\Resources\ProductResource;
use Modules\Core\Filament\Resources\ProductResource\Pages\ListProducts as BaseListProducts;

class ListProducts extends BaseListProducts
{
    protected static string $resource = ProductResource::class;
}
