<?php

namespace Modules\Invoices\Filament\Clusters\Orders\Resources\CustomerResource\Pages;

use Modules\Crm\Filament\Resources\PartnerResource\Pages\ViewPartner as BaseViewCustomer;
use Modules\Invoices\Filament\Clusters\Orders\Resources\CustomerResource;

class ViewCustomer extends BaseViewCustomer
{
    protected static string $resource = CustomerResource::class;
}
