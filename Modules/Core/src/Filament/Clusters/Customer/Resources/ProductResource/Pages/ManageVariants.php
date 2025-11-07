<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\ProductResource\Pages;

use Modules\Core\Filament\Clusters\Customer\Resources\ProductResource;
use Modules\Core\Filament\Resources\ProductResource\Pages\ManageVariants as BaseManageVariants;

class ManageVariants extends BaseManageVariants
{
    protected static string $resource = ProductResource::class;
}
