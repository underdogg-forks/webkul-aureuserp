<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource\Pages;

use Modules\Core\Filament\Clusters\Vendors\Resources\VendorResource\Pages\EditVendor as BaseEditVendor;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource;

class EditVendor extends BaseEditVendor
{
    protected static string $resource = VendorResource::class;
}
