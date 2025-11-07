<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources;

use BackedEnum;
use Modules\Core\Filament\Resources\AttributeResource;
use Modules\Expenses\Filament\Admin\Clusters\Configurations;
use Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductAttributeResource\Pages\CreateProductAttribute;
use Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductAttributeResource\Pages\EditProductAttribute;
use Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductAttributeResource\Pages\ListProductAttributes;
use Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductAttributeResource\Pages\ViewProductAttribute;
use Modules\Expenses\Models\Attribute;
use Modules\Expenses\Settings\ProductSettings;

class ProductAttributeResource extends AttributeResource
{
    protected static ?string $model = Attribute::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-swatch';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?int $navigationSort = 9;

    protected static ?string $cluster = Configurations::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function isDiscovered(): bool
    {
        if (app()->runningInConsole()) {
            return true;
        }

        return app(ProductSettings::class)->enable_variants;
    }

    public static function getNavigationGroup(): string
    {
        return __('purchases::filament/admin/clusters/configurations/resources/product-attribute.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('purchases::filament/admin/clusters/configurations/resources/product-attribute.navigation.title');
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListProductAttributes::route('/'),
            'create' => CreateProductAttribute::route('/create'),
            'view'   => ViewProductAttribute::route('/{record}'),
            'edit'   => EditProductAttribute::route('/{record}/edit'),
        ];
    }
}
