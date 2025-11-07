<?php

namespace Modules\Products\Filament\Clusters\Configurations\Resources\ProductAttributeResource\Pages;

use Modules\Products\Filament\Clusters\Configurations\Resources\ProductAttributeResource;
use Modules\Core\Filament\Resources\AttributeResource\Pages\ListAttributes;

class ListProductAttributes extends ListAttributes
{
    protected static string $resource = ProductAttributeResource::class;
}
