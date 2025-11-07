<?php

namespace Modules\Invoices\Filament\Clusters\Orders\Resources\CustomerResource\Pages;

use Modules\Core\Filament\Clusters\Customer\Resources\PartnerResource\Pages\ManageBankAccounts as BaseManageBankAccounts;
use Modules\Invoices\Filament\Clusters\Orders\Resources\CustomerResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ManageBankAccounts extends BaseManageBankAccounts
{
    use HasRecordNavigationTabs;

    protected static string $resource = CustomerResource::class;
}
