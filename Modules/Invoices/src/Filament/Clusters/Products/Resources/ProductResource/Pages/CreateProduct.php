<?php

namespace Modules\Invoices\Filament\Clusters\Products\Resources\ProductResource\Pages;

use Modules\Core\Filament\Clusters\Vendors\Resources\ProductResource\Pages\CreateProduct as BaseCreateProduct;
use Modules\Invoices\Filament\Clusters\Products\Resources\ProductResource;

class CreateProduct extends BaseCreateProduct
{
    protected static string $resource = ProductResource::class;
}
