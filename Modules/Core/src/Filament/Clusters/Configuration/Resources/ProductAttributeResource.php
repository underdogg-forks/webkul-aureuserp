<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources;

use Modules\Core\Filament\Clusters\Configuration;
use Modules\Core\Filament\Clusters\Configuration\Resources\ProductAttributeResource\Pages\CreateProductAttribute;
use Modules\Core\Filament\Clusters\Configuration\Resources\ProductAttributeResource\Pages\EditProductAttribute;
use Modules\Core\Filament\Clusters\Configuration\Resources\ProductAttributeResource\Pages\ListProductAttributes;
use Modules\Core\Filament\Clusters\Configuration\Resources\ProductAttributeResource\Pages\ViewProductAttribute;
use Modules\Core\Models\Attribute;
use Modules\Core\Filament\Resources\AttributeResource;

class ProductAttributeResource extends AttributeResource
{
    protected static ?string $model = Attribute::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?int $navigationSort = 9;

    protected static ?string $cluster = Configuration::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): string
    {
        return __('invoices::filament/clusters/configurations/resources/product-attribute.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('invoices::filament/clusters/configurations/resources/product-attribute.navigation.title');
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
