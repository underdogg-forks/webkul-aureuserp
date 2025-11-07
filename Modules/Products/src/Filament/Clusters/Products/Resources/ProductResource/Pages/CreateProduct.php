<?php

namespace Modules\Products\Filament\Clusters\Products\Resources\ProductResource\Pages;

use Modules\Products\Filament\Clusters\Products\Resources\ProductResource;
use Modules\Core\Filament\Resources\ProductResource\Pages\CreateProduct as BaseCreateProduct;

class CreateProduct extends BaseCreateProduct
{
    protected static string $resource = ProductResource::class;
}
