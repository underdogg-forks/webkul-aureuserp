<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources;

use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Utilities\Get;
use Modules\Core\Filament\Resources\InvoiceResource as BaseInvoiceResource;
use Modules\Core\Filament\Clusters\Customer;
use Modules\Core\Filament\Clusters\Customer\Resources\InvoiceResource\Pages\CreateInvoice;
use Modules\Core\Filament\Clusters\Customer\Resources\InvoiceResource\Pages\EditInvoice;
use Modules\Core\Filament\Clusters\Customer\Resources\InvoiceResource\Pages\ListInvoices;
use Modules\Core\Filament\Clusters\Customer\Resources\InvoiceResource\Pages\ViewInvoice;
use Modules\Core\Models\Invoice;
use Modules\Core\Filament\Forms\Components\Repeater;

class InvoiceResource extends BaseInvoiceResource
{
    protected static ?string $model = Invoice::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $cluster = Customer::class;

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('invoices::filament/clusters/customers/resources/invoice.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('invoices::filament/clusters/customers/resources/invoice.navigation.title');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name',
            'invoice_partner_display_name',
            'invoice_date',
            'invoice_date_due',
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewInvoice::class,
            EditInvoice::class,
        ]);
    }

    public static function getProductRepeater(): Repeater
    {
        return parent::getProductRepeater()
            ->extraItemActions([
                Action::make('openProduct')
                    ->tooltip('Open product')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->url(
                        fn (array $arguments, Get $get): ?string => ProductResource::getUrl('edit', [
                            'record' => $get("products.{$arguments['item']}.product_id"),
                        ])
                    )
                    ->openUrlInNewTab()
                    ->visible(
                        fn (array $arguments, Get $get): bool => filled($get("products.{$arguments['item']}.product_id"))
                    ),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListInvoices::route('/'),
            'create' => CreateInvoice::route('/create'),
            'view'   => ViewInvoice::route('/{record}'),
            'edit'   => EditInvoice::route('/{record}/edit'),
        ];
    }
}
