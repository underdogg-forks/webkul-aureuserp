<?php

namespace Modules\Core\Filament\Admin\Resources;

use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\RelationManagers\RelationGroup;
use Modules\Crm\Filament\Resources\PartnerResource as BasePartnerResource;
use Modules\Crm\Filament\Resources\PartnerResource\RelationManagers\AddressesRelationManager;
use Modules\Crm\Filament\Resources\PartnerResource\RelationManagers\ContactsRelationManager;
use Modules\Core\Filament\Admin\Resources\PartnerResource\Pages\CreatePartner;
use Modules\Core\Filament\Admin\Resources\PartnerResource\Pages\EditPartner;
use Modules\Core\Filament\Admin\Resources\PartnerResource\Pages\ListPartners;
use Modules\Core\Filament\Admin\Resources\PartnerResource\Pages\ManageAddresses;
use Modules\Core\Filament\Admin\Resources\PartnerResource\Pages\ManageContacts;
use Modules\Core\Filament\Admin\Resources\PartnerResource\Pages\ViewPartner;
use Modules\Core\Models\Partner;

class PartnerResource extends BasePartnerResource
{
    protected static ?string $model = Partner::class;

    protected static ?string $slug = 'website/contacts';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function getNavigationLabel(): string
    {
        return __('website::filament/admin/resources/partner.navigation.title');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('website::filament/admin/resources/partner.navigation.group');
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewPartner::class,
            EditPartner::class,
            ManageContacts::class,
            ManageAddresses::class,
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
            'index'     => ListPartners::route('/'),
            'create'    => CreatePartner::route('/create'),
            'view'      => ViewPartner::route('/{record}'),
            'edit'      => EditPartner::route('/{record}/edit'),
            'contacts'  => ManageContacts::route('/{record}/contacts'),
            'addresses' => ManageAddresses::route('/{record}/addresses'),
        ];
    }
}
