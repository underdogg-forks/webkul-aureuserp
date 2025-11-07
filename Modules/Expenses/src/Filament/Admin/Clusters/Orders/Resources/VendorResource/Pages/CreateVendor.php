<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource\Pages;

use Modules\Core\Filament\Clusters\Vendors\Resources\VendorResource\Pages\CreateVendor as BaseCreateVendor;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource;

class CreateVendor extends BaseCreateVendor
{
    protected static string $resource = VendorResource::class;
}
