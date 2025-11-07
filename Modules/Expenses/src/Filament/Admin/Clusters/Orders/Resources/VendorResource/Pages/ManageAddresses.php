<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource\Pages;

use Modules\Core\Filament\Clusters\Vendors\Resources\VendorResource\Pages\ManageAddresses as BaseManageAddresses;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource;

class ManageAddresses extends BaseManageAddresses
{
    protected static string $resource = VendorResource::class;
}
