<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource\Pages;

use Modules\Core\Filament\Clusters\Vendors\Resources\VendorResource\Pages\ViewVendor as BaseViewVendor;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource;

class ViewVendor extends BaseViewVendor
{
    protected static string $resource = VendorResource::class;
}
