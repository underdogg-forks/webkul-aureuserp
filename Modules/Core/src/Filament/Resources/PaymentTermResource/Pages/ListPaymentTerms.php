<?php

namespace Modules\Core\Filament\Resources\PaymentTermResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Modules\Core\Filament\Resources\PaymentTermResource;
use Modules\Core\Models\PaymentTerm;

class ListPaymentTerms extends ListRecords
{
    protected static string $resource = PaymentTermResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__('accounts::filament/resources/payment-term/pages/list-payment-term.tabs.all'))
                ->badge(PaymentTerm::count()),
            'archived' => Tab::make(__('accounts::filament/resources/payment-term/pages/list-payment-term.tabs.archived'))
                ->badge(PaymentTerm::onlyTrashed()->count())
                ->modifyQueryUsing(fn ($query) => $query->onlyTrashed()),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
