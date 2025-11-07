<?php

namespace Modules\Core\Filament\Resources\CreditNoteResource\Pages;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Modules\Core\Enums\MoveType;
use Modules\Core\Filament\Resources\CreditNoteResource;
use Modules\Core\Filament\Resources\InvoiceResource\Pages\ListInvoices as ListRecords;
use Modules\Core\Filament\Components\PresetView;
use Modules\Core\Filament\Concerns\HasTableViews;

class ListCreditNotes extends ListRecords
{
    use HasTableViews;

    protected static string $resource = CreditNoteResource::class;

    public function getPresetTableViews(): array
    {
        $predefinedViews = parent::getPresetTableViews();

        return [
            'out_refund' => PresetView::make(__('accounts::filament/resources/credit-note/pages/list-credit-note.tabs.credit-notes'))
                ->favorite()
                ->setAsDefault()
                ->icon('heroicon-s-receipt-percent')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('move_type', MoveType::OUT_REFUND)),
            ...Arr::except($predefinedViews, ['invoice']),
        ];
    }
}
