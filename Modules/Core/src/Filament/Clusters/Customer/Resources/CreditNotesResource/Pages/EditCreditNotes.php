<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources\CreditNotesResource\Pages;

use Modules\Core\Filament\Resources\CreditNoteResource\Pages\EditCreditNote as BaseCreditNote;
use Modules\Core\Filament\Clusters\Customer\Resources\CreditNotesResource;

class EditCreditNotes extends BaseCreditNote
{
    protected static string $resource = CreditNotesResource::class;
}
