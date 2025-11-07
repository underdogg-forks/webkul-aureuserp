<?php

namespace Modules\Invoices\Filament\Clusters\Products\Resources\ProductResource\Pages;

use Modules\Core\Filament\Clusters\Vendors\Resources\ProductResource\Pages\ManageAttributes as BaseManageAttributes;
use Modules\Invoices\Filament\Clusters\Products\Resources\ProductResource;

class ManageAttributes extends BaseManageAttributes
{
    protected static string $resource = ProductResource::class;
}
