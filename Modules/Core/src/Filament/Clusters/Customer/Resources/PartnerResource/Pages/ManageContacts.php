<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\PartnerResource\Pages;

use Modules\Core\Filament\Clusters\Customer\Resources\PartnerResource;
use Modules\Core\Filament\Clusters\Vendors\Resources\VendorResource\Pages\ManageContacts as BaseManageContacts;

class ManageContacts extends BaseManageContacts
{
    protected static string $resource = PartnerResource::class;
}
