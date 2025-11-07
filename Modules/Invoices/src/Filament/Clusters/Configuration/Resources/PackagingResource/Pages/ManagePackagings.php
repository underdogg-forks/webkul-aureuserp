<?php

namespace Modules\Invoices\Filament\Clusters\Configuration\Resources\PackagingResource\Pages;

use Modules\Core\Filament\Resources\PackagingResource\Pages\ManagePackagings as BaseManagePackagings;
use Modules\Invoices\Filament\Clusters\Configuration\Resources\PackagingResource;

class ManagePackagings extends BaseManagePackagings
{
    protected static string $resource = PackagingResource::class;
}
