<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\InvoiceResource\Pages;

use Modules\Core\Filament\Resources\InvoiceResource\Pages\EditInvoice as BaseEditInvoice;
use Modules\Core\Filament\Clusters\Customer\Resources\InvoiceResource;

class EditInvoice extends BaseEditInvoice
{
    protected static string $resource = InvoiceResource::class;
}
