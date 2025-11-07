<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\CreditNotesResource\Pages;

use Modules\Core\Filament\Resources\CreditNoteResource\Pages\CreateCreditNote as BaseCreateInvoice;
use Modules\Core\Filament\Clusters\Customer\Resources\CreditNotesResource;

class CreateCreditNotes extends BaseCreateInvoice
{
    protected static string $resource = CreditNotesResource::class;
}
