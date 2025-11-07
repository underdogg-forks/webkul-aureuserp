<?php

namespace Modules\Invoices\Filament\Clusters\Orders\Resources\CustomerResource\Pages;

use Modules\Core\Filament\Clusters\Customer\Resources\PartnerResource\Pages\ManageContacts as BaseManageContacts;
use Modules\Invoices\Filament\Clusters\Orders\Resources\CustomerResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ManageContacts extends BaseManageContacts
{
    use HasRecordNavigationTabs;

    protected static string $resource = CustomerResource::class;
}
