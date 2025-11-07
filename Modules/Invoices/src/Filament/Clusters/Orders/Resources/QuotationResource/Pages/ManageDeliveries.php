<?php

namespace Modules\Invoices\Filament\Clusters\Orders\Resources\QuotationResource\Pages;

use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Table;
use Livewire\Livewire;
use Modules\Products\Filament\Clusters\Operations\Resources\DeliveryResource;
use Modules\Products\Filament\Clusters\Operations\Resources\OperationResource;
use Modules\Invoices\Filament\Clusters\Orders\Resources\QuotationResource;
use Modules\Core\Package;
use Modules\Core\Traits\HasRecordNavigationTabs;

class ManageDeliveries extends ManageRelatedRecords
{
    use HasRecordNavigationTabs;

    protected static string $resource = QuotationResource::class;

    protected static string $relationship = 'operations';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-truck';

    public static function canAccess(array $parameters = []): bool
    {
        $canAccess = parent::canAccess($parameters);

        if ( ! $canAccess) {
            return false;
        }

        return Package::isPluginInstalled('inventories');
    }

    public static function getNavigationLabel(): string
    {
        return __('sales::filament/clusters/orders/resources/quotation/pages/manage-deliveries.navigation.title');
    }

    public static function getNavigationBadge($parameters = []): ?string
    {
        return Livewire::current()->getRecord()->operations()->count();
    }

    public function table(Table $table): Table
    {
        return OperationResource::table($table)
            ->actions([
                ViewAction::make()
                    ->url(fn ($record) => DeliveryResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(false),

                EditAction::make()
                    ->url(fn ($record) => DeliveryResource::getUrl('edit', ['record' => $record]))
                    ->openUrlInNewTab(false),
            ])
            ->toolbarActions([]);
    }
}
