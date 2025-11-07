<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource\Pages;

use Modules\Core\Filament\Resources\ProductResource\Pages\CreateProduct as BaseCreateProduct;
use Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource;

class CreateProduct extends BaseCreateProduct
{
    protected static string $resource = ProductResource::class;
}
