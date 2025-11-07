<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductAttributeResource\Pages;

use Modules\Core\Filament\Resources\AttributeResource\Pages\ListAttributes;
use Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductAttributeResource;

class ListProductAttributes extends ListAttributes
{
    protected static string $resource = ProductAttributeResource::class;
}
