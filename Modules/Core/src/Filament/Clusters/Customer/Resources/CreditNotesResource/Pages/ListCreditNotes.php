<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\CreditNotesResource\Pages;

use Modules\Core\Filament\Resources\CreditNoteResource\Pages\ListCreditNotes as BaseListInvoices;
use Modules\Core\Filament\Clusters\Customer\Resources\CreditNotesResource;

class ListCreditNotes extends BaseListInvoices
{
    protected static string $resource = CreditNotesResource::class;
}
