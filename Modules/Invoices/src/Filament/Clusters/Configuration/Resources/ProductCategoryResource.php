<?php

namespace Modules\Invoices\Filament\Clusters\Configuration\Resources;

use Filament\Resources\Pages\Page;
use Modules\Core\Filament\Clusters\Configuration\Resources\ProductCategoryResource as BaseProductCategoryResource;
use Modules\Invoices\Filament\Clusters\Configuration;
use Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages\CreateProductCategory;
use Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages\EditProductCategory;
use Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages\ListProductCategories;
use Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages\ManageProducts;
use Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages\ViewProductCategory;
use Modules\Invoices\Models\Category;

class ProductCategoryResource extends BaseProductCategoryResource
{
    protected static ?string $model = Category::class;

    protected static ?string $cluster = Configuration::class;

    public static function getNavigationGroup(): ?string
    {
        return __('sales::filament/clusters/configurations/resources/product-category.navigation.group');
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewProductCategory::class,
            EditProductCategory::class,
            ManageProducts::class,
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'    => ListProductCategories::route('/'),
            'create'   => CreateProductCategory::route('/create'),
            'view'     => ViewProductCategory::route('/{record}'),
            'edit'     => EditProductCategory::route('/{record}/edit'),
            'products' => ManageProducts::route('/{record}/products'),
        ];
    }
}
