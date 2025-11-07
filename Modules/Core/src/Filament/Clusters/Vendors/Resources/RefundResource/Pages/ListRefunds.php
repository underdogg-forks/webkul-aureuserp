<?php

namespace Modules\Core\Filament\Clusters\Vendors\Resources\RefundResource\Pages;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Modules\Core\Enums\MoveType;
use Modules\Core\Filament\Resources\InvoiceResource\Pages\ListInvoices as BaseListInvoices;
use Modules\Core\Filament\Clusters\Vendors\Resources\RefundResource;
use Modules\Core\Filament\Components\PresetView;
use Modules\Core\Filament\Concerns\HasTableViews;

class ListRefunds extends BaseListInvoices
{
    use HasTableViews;

    protected static string $resource = RefundResource::class;

    public function getPresetTableViews(): array
    {
        $predefinedViews = parent::getPresetTableViews();

        return [
            'in_refund' => PresetView::make(__('Refunds'))
                ->favorite()
                ->setAsDefault()
                ->icon('heroicon-s-receipt-percent')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('move_type', MoveType::IN_REFUND)),
            ...Arr::except($predefinedViews, ['invoice', 'in_refund']),
        ];
    }
}
