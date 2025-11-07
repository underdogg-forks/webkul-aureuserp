<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource\Pages;

use Modules\Core\Filament\Clusters\Vendors\Resources\VendorResource\Pages\ManageContacts as BaseManageContacts;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource;

class ManageContacts extends BaseManageContacts
{
    protected static string $resource = VendorResource::class;
}
