<?php

namespace Modules\Core\Filament\Resources\TaxResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Modules\Core\Enums\DocumentType;
use Modules\Core\Traits\TaxPartition;

class DistributionForInvoiceRelationManager extends RelationManager
{
    use TaxPartition;

    protected static string $relationship = 'distributionForInvoice';

    protected static ?string $title = 'Distribution for Invoice';

    public function getDocumentType(): string
    {
        return DocumentType::INVOICE->value;
    }
}
