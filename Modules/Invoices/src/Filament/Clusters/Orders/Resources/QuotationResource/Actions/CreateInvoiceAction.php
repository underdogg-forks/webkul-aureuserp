<?php

namespace Modules\Invoices\Filament\Clusters\Orders\Resources\QuotationResource\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Arr;
use Modules\Invoices\Enums\AdvancedPayment;
use Modules\Invoices\Enums\InvoiceStatus;
use Modules\Invoices\Facades\SaleOrder as SalesFacade;
use Modules\Invoices\Models\Order;

class CreateInvoiceAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->color(function (Order $record): string {
                if ($record->invoice_status != InvoiceStatus::TO_INVOICE) {
                    return 'gray';
                }

                return 'primary';
            })
            ->label(__('sales::filament/clusters/orders/resources/quotation/actions/create-invoice.title'))
            ->schema([
                Radio::make('advance_payment_method')
                    ->inline(false)
                    ->label(__('sales::filament/clusters/orders/resources/quotation/actions/create-invoice.form.fields.create-invoice'))
                    ->options(function () {
                        $options = AdvancedPayment::options();

                        return Arr::only($options, [
                            AdvancedPayment::DELIVERED->value,
                        ]);
                    })
                    ->default(AdvancedPayment::DELIVERED->value)
                    ->live(),
                Group::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('amount')
                            ->visible(fn (Get $get) => $get('advance_payment_method') == AdvancedPayment::PERCENTAGE->value)
                            ->rules('required', 'numeric')
                            ->default(0.00)
                            ->suffix('%'),
                        TextInput::make('amount')
                            ->visible(fn (Get $get) => $get('advance_payment_method') == AdvancedPayment::FIXED->value)
                            ->rules('required', 'numeric')
                            ->default(0.00)
                            ->prefix(fn ($record) => $record->currency->symbol),
                    ]),
            ])
            ->hidden(fn ($record) => $record->invoice_status != InvoiceStatus::TO_INVOICE)
            ->action(function (Order $record, $data) {
                SalesFacade::createInvoice($record, $data);

                Notification::make()
                    ->title(__('sales::filament/clusters/orders/resources/quotation/actions/create-invoice.notification.invoice-created.title'))
                    ->body(__('sales::filament/clusters/orders/resources/quotation/actions/create-invoice.notification.invoice-created.body'))
                    ->success()
                    ->send();
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'orders.sales.create-invoice';
    }
}
