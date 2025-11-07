<?php

namespace Modules\Invoices\Filament\Clusters\Configuration\Resources;

use BackedEnum;
use Modules\Core\Filament\Resources\PackagingResource as BasePackagingResource;
use Modules\Invoices\Filament\Clusters\Configuration;
use Modules\Invoices\Filament\Clusters\Configuration\Resources\PackagingResource\Pages\ManagePackagings;
use Modules\Invoices\Models\Packaging;
use Modules\Invoices\Settings\ProductSettings;

class PackagingResource extends BasePackagingResource
{
    protected static ?string $model = Packaging::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-gift';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $cluster = Configuration::class;

    public static function isDiscovered(): bool
    {
        if (app()->runningInConsole()) {
            return true;
        }

        return app(ProductSettings::class)->enable_packagings;
    }

    public static function getNavigationGroup(): string
    {
        return __('Packagings');
    }

    public static function getNavigationLabel(): string
    {
        return __('Products');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePackagings::route('/'),
        ];
    }
}
