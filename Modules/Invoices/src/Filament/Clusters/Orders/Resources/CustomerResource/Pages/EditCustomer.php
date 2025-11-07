<?php

namespace Modules\Invoices\Filament\Clusters\Orders\Resources\CustomerResource\Pages;

use Illuminate\Contracts\Support\Htmlable;
use Modules\Crm\Filament\Resources\PartnerResource\Pages\EditPartner as BaseEditCustomer;
use Modules\Invoices\Filament\Clusters\Orders\Resources\CustomerResource;
use Modules\Core\Traits\HasRecordNavigationTabs;

class EditCustomer extends BaseEditCustomer
{
    use HasRecordNavigationTabs;

    protected static string $resource = CustomerResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('sales::filament/clusters/orders/resources/customer/pages/edit-customer.title');
    }
}
