<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources;

use Modules\Core\Filament\Resources\TaxResource as BaseTaxResource;
use Modules\Core\Filament\Clusters\Configuration;
use Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource\Pages\CreateTax;
use Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource\Pages\EditTax;
use Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource\Pages\ListTaxes;
use Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource\Pages\ManageDistributionForInvoice;
use Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource\Pages\ManageDistributionForRefund;
use Modules\Core\Filament\Clusters\Configuration\Resources\TaxResource\Pages\ViewTax;
use Modules\Core\Models\Tax;

class TaxResource extends BaseTaxResource
{
    protected static ?string $model = Tax::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $cluster = Configuration::class;

    public static function getModelLabel(): string
    {
        return __('invoices::filament/clusters/configurations/resources/tax.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('invoices::filament/clusters/configurations/resources/tax.navigation.title');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('invoices::filament/clusters/configurations/resources/tax.navigation.group');
    }

    public static function getPages(): array
    {
        return [
            'index'                           => ListTaxes::route('/'),
            'create'                          => CreateTax::route('/create'),
            'view'                            => ViewTax::route('/{record}'),
            'edit'                            => EditTax::route('/{record}/edit'),
            'manage-distribution-for-invoice' => ManageDistributionForInvoice::route('/{record}/manage-distribution-for-invoice'),
            'manage-distribution-for-refunds' => ManageDistributionForRefund::route('/{record}/manage-distribution-for-refunds'),
        ];
    }
}
