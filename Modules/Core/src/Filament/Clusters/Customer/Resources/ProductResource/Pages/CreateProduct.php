<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\ProductResource\Pages;

use Modules\Core\Filament\Clusters\Customer\Resources\ProductResource;
use Modules\Core\Filament\Resources\ProductResource\Pages\CreateProduct as BaseCreateProduct;

class CreateProduct extends BaseCreateProduct
{
    protected static string $resource = ProductResource::class;
}
