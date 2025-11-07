<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\ProductAttributeResource\Pages;

use Modules\Core\Filament\Clusters\Configuration\Resources\ProductAttributeResource;
use Modules\Core\Filament\Resources\AttributeResource\Pages\ListAttributes;

class ListProductAttributes extends ListAttributes
{
    protected static string $resource = ProductAttributeResource::class;
}
