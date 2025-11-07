<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\InvoiceResource\Pages;

use Modules\Core\Filament\Resources\InvoiceResource\Pages\ListInvoices as BaseListInvoices;
use Modules\Core\Filament\Clusters\Customer\Resources\InvoiceResource;

class ListInvoices extends BaseListInvoices
{
    protected static string $resource = InvoiceResource::class;
}
