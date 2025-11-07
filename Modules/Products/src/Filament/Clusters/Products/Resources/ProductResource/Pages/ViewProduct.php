<?php

namespace Modules\Products\Filament\Clusters\Products\Resources\ProductResource\Pages;

use Modules\Products\Filament\Clusters\Products\Resources\ProductResource;
use Modules\Core\Filament\Resources\ProductResource\Pages\ViewProduct as BaseViewProduct;

class ViewProduct extends BaseViewProduct
{
    protected static string $resource = ProductResource::class;
}
