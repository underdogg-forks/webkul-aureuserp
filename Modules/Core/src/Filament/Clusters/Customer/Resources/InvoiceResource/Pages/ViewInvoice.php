<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\InvoiceResource\Pages;

use Modules\Core\Filament\Resources\InvoiceResource\Pages\ViewInvoice as BaseViewInvoice;
use Modules\Core\Filament\Clusters\Customer\Resources\InvoiceResource;

class ViewInvoice extends BaseViewInvoice
{
    protected static string $resource = InvoiceResource::class;
}
