<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\PackagingResource\Pages;

use Modules\Core\Filament\Resources\PackagingResource\Pages\ManagePackagings as BaseManagePackagings;
use Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\PackagingResource;

class ManagePackagings extends BaseManagePackagings
{
    protected static string $resource = PackagingResource::class;
}
