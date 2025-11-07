<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\CreditNotesResource\Pages;

use Modules\Core\Filament\Resources\CreditNoteResource\Pages\ViewCreditNote as BaseViewInvoice;
use Modules\Core\Filament\Clusters\Customer\Resources\CreditNotesResource;

class ViewCreditNote extends BaseViewInvoice
{
    protected static string $resource = CreditNotesResource::class;
}
