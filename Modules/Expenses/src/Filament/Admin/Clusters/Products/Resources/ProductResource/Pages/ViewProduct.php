<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource\Pages;

use Modules\Core\Filament\Resources\ProductResource\Pages\ViewProduct as BaseViewProduct;
use Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource;

class ViewProduct extends BaseViewProduct
{
    protected static string $resource = ProductResource::class;
}
