<?php

namespace Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductAttributeResource\Pages;

use Modules\Core\Filament\Clusters\Configuration\Resources\ProductAttributeResource\Pages\ListProductAttributes as BaseListProductAttributes;
use Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductAttributeResource;

class ListProductAttributes extends BaseListProductAttributes
{
    protected static string $resource = ProductAttributeResource::class;
}
