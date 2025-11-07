<?php

namespace Modules\Core\Filament\Clusters\Customer\Resources;

use Modules\Core\Filament\Resources\PaymentsResource as BasePaymentsResource;
use Modules\Core\Filament\Clusters\Customer;
use Modules\Core\Filament\Clusters\Customer\Resources\PaymentsResource\Pages\CreatePayments;
use Modules\Core\Filament\Clusters\Customer\Resources\PaymentsResource\Pages\EditPayments;
use Modules\Core\Filament\Clusters\Customer\Resources\PaymentsResource\Pages\ListPayments;
use Modules\Core\Filament\Clusters\Customer\Resources\PaymentsResource\Pages\ViewPayments;
use Modules\Core\Models\Payment;

class PaymentsResource extends BasePaymentsResource
{
    protected static ?string $model = Payment::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?int $navigationSort = 4;

    protected static ?string $cluster = Customer::class;

    public static function getModelLabel(): string
    {
        return __('invoices::filament/clusters/customers/resources/payment.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('invoices::filament/clusters/customers/resources/payment.navigation.title');
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPayments::route('/'),
            'create' => CreatePayments::route('/create'),
            'view'   => ViewPayments::route('/{record}'),
            'edit'   => EditPayments::route('/{record}/edit'),
        ];
    }
}
