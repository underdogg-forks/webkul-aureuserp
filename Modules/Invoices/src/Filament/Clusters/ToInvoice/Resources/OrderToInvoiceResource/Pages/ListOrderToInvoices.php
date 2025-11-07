<?php

namespace Modules\Invoices\Filament\Clusters\ToInvoice\Resources\OrderToInvoiceResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Modules\Invoices\Filament\Clusters\ToInvoice\Resources\OrderToInvoiceResource;
use Modules\Core\Filament\Components\PresetView;
use Modules\Core\Filament\Concerns\HasTableViews;

class ListOrderToInvoices extends ListRecords
{
    use HasTableViews;

    protected static string $resource = OrderToInvoiceResource::class;

    public function getPresetTableViews(): array
    {
        return [
            'my_orders' => PresetView::make(__('sales::filament/clusters/to-invoice/resources/order-to-invoice/pages/list-order-to-invoice.tabs.my-orders'))
                ->icon('heroicon-s-shopping-bag')
                ->favorite()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', Auth::id())),
            'archived' => PresetView::make(__('sales::filament/clusters/to-invoice/resources/order-to-invoice/pages/list-order-to-invoice.tabs.archived'))
                ->icon('heroicon-s-archive-box')
                ->favorite()
                ->modifyQueryUsing(fn ($query) => $query->onlyTrashed()),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
