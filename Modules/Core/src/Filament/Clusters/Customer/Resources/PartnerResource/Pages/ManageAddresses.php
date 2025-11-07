<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\PartnerResource\Pages;

use Modules\Core\Filament\Clusters\Customer\Resources\PartnerResource;
use Modules\Core\Filament\Clusters\Vendors\Resources\VendorResource\Pages\ManageAddresses as BaseManageAddresses;

class ManageAddresses extends BaseManageAddresses
{
    protected static string $resource = PartnerResource::class;
}
