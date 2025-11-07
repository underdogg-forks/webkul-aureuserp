<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources;

use BackedEnum;
use Modules\Core\Filament\Resources\PackagingResource as BasePackagingResource;
use Modules\Expenses\Filament\Admin\Clusters\Configurations;
use Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\PackagingResource\Pages\ManagePackagings;
use Modules\Expenses\Models\Packaging;
use Modules\Expenses\Settings\ProductSettings;

class PackagingResource extends BasePackagingResource
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-gift';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?int $navigationSort = 10;

    protected static ?string $model = Packaging::class;

    protected static ?string $cluster = Configurations::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function isDiscovered(): bool
    {
        if (app()->runningInConsole()) {
            return true;
        }

        return app(ProductSettings::class)->enable_packagings;
    }

    public static function getNavigationGroup(): string
    {
        return __('purchases::filament/admin/clusters/configurations/resources/packaging.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('purchases::filament/admin/clusters/configurations/resources/packaging.navigation.title');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePackagings::route('/'),
        ];
    }
}
