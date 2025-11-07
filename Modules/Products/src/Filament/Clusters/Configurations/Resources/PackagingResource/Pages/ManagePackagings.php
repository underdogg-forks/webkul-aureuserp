<?php

namespace Modules\Products\Filament\Clusters\Configurations\Resources\PackagingResource\Pages;

use Modules\Products\Filament\Clusters\Configurations\Resources\PackagingResource;
use Modules\Core\Filament\Resources\PackagingResource\Pages\ManagePackagings as BaseManagePackagings;

class ManagePackagings extends BaseManagePackagings
{
    protected static string $resource = PackagingResource::class;
}
