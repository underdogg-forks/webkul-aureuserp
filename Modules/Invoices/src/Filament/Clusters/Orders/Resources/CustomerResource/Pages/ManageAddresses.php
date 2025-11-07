<?php

namespace Modules\Invoices\Filament\Clusters\Orders\Resources\CustomerResource\Pages;

use Modules\Core\Filament\Clusters\Customer\Resources\PartnerResource\Pages\ManageAddresses as BaseManageAddresses;
use Modules\Invoices\Filament\Clusters\Orders\Resources\CustomerResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ManageAddresses extends BaseManageAddresses
{
    use HasRecordNavigationTabs;

    protected static string $resource = CustomerResource::class;
}
