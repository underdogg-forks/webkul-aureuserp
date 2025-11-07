<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource\Pages;

use Modules\Core\Filament\Resources\ProductResource\Pages\EditProduct as BaseEditProduct;
use Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource;

class EditProduct extends BaseEditProduct
{
    protected static string $resource = ProductResource::class;
}
