<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources;

use Filament\Resources\Pages\Page;
use Modules\Core\Filament\Resources\PaymentTermResource as BasePaymentTermResource;
use Modules\Core\Filament\Clusters\Configuration;
use Modules\Core\Filament\Clusters\Configuration\Resources\PaymentTermResource\Pages\CreatePaymentTerm;
use Modules\Core\Filament\Clusters\Configuration\Resources\PaymentTermResource\Pages\EditPaymentTerm;
use Modules\Core\Filament\Clusters\Configuration\Resources\PaymentTermResource\Pages\ListPaymentTerms;
use Modules\Core\Filament\Clusters\Configuration\Resources\PaymentTermResource\Pages\ManagePaymentDueTerm;
use Modules\Core\Filament\Clusters\Configuration\Resources\PaymentTermResource\Pages\ViewPaymentTerm;
use Modules\Core\Models\PaymentTerm;

class PaymentTermResource extends BasePaymentTermResource
{
    protected static ?string $model = PaymentTerm::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $cluster = Configuration::class;

    public static function getModelLabel(): string
    {
        return __('invoices::filament/clusters/configurations/resources/payment-term.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('invoices::filament/clusters/configurations/resources/payment-term.navigation.title');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('invoices::filament/clusters/configurations/resources/payment-term.navigation.group');
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewPaymentTerm::class,
            EditPaymentTerm::class,
            ManagePaymentDueTerm::class,
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'             => ListPaymentTerms::route('/'),
            'create'            => CreatePaymentTerm::route('/create'),
            'view'              => ViewPaymentTerm::route('/{record}'),
            'edit'              => EditPaymentTerm::route('/{record}/edit'),
            'payment-due-terms' => ManagePaymentDueTerm::route('/{record}/payment-due-terms'),
        ];
    }
}
