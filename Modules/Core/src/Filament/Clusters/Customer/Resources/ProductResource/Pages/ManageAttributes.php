<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\ProductResource\Pages;

use Modules\Core\Filament\Clusters\Customer\Resources\ProductResource;
use Modules\Core\Filament\Resources\ProductResource\Pages\ManageAttributes as BaseManageAttributes;

class ManageAttributes extends BaseManageAttributes
{
    protected static string $resource = ProductResource::class;
}
