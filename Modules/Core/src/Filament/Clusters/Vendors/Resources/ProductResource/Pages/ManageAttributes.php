<?php

namespace Modules\Core\Filament\Clusters\Vendors\Resources\ProductResource\Pages;

use BackedEnum;
use Modules\Core\Filament\Clusters\Vendors\Resources\ProductResource;
use Modules\Core\Filament\Resources\ProductResource\Pages\ManageAttributes as BaseManageAttributes;

class ManageAttributes extends BaseManageAttributes
{
    protected static string $resource = ProductResource::class;

    protected static string $relationship = 'attributes';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-swatch';
}
