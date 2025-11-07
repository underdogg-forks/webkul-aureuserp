<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Orders\Resources;

use BackedEnum;
use Filament\Resources\Pages\Page;
use Filament\Resources\RelationManagers\RelationGroup;
use Modules\Core\Filament\Traits\HasCustomFields;
use Modules\Core\Filament\Clusters\Vendors\Resources\VendorResource as BaseVendorResource;
use Modules\Crm\Filament\Resources\PartnerResource\RelationManagers\AddressesRelationManager;
use Modules\Crm\Filament\Resources\PartnerResource\RelationManagers\ContactsRelationManager;
use Modules\Expenses\Filament\Admin\Clusters\Orders;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource\Pages\CreateVendor;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource\Pages\EditVendor;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource\Pages\ListVendors;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource\Pages\ManageAddresses;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource\Pages\ManageBills;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource\Pages\ManageContacts;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource\Pages\ManagePurchases;
use Modules\Expenses\Filament\Admin\Clusters\Orders\Resources\VendorResource\Pages\ViewVendor;
use Modules\Expenses\Models\Partner;

class VendorResource extends BaseVendorResource
{
    use HasCustomFields;

    protected static ?string $model = Partner::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $cluster = Orders::class;

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationLabel(): string
    {
        return __('purchases::filament/admin/clusters/orders/resources/vendor.navigation.title');
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewVendor::class,
            EditVendor::class,
            ManageContacts::class,
            ManageAddresses::class,
            ManageBills::class,
            ManagePurchases::class,
        ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationGroup::make('Contacts', [
                ContactsRelationManager::class,
            ])
                ->icon('heroicon-o-users'),

            RelationGroup::make('Addresses', [
                AddressesRelationManager::class,
            ])
                ->icon('heroicon-o-map-pin'),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'     => ListVendors::route('/'),
            'create'    => CreateVendor::route('/create'),
            'view'      => ViewVendor::route('/{record}'),
            'edit'      => EditVendor::route('/{record}/edit'),
            'contacts'  => ManageContacts::route('/{record}/contacts'),
            'addresses' => ManageAddresses::route('/{record}/addresses'),
            'bills'     => ManageBills::route('/{record}/bills'),
            'purchases' => ManagePurchases::route('/{record}/purchases'),
        ];
    }
}
