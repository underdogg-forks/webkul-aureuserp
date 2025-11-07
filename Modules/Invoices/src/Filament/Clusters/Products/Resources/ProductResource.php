<?php

namespace Modules\Invoices\Filament\Clusters\Products\Resources;

use BackedEnum;
use Filament\Resources\Pages\Page;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Modules\Core\Filament\Clusters\Customer\Resources\ProductResource as BaseProductResource;
use Modules\Invoices\Filament\Clusters\Products;
use Modules\Invoices\Filament\Clusters\Products\Resources\ProductResource\Pages\CreateProduct;
use Modules\Invoices\Filament\Clusters\Products\Resources\ProductResource\Pages\EditProduct;
use Modules\Invoices\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts;
use Modules\Invoices\Filament\Clusters\Products\Resources\ProductResource\Pages\ManageAttributes;
use Modules\Invoices\Filament\Clusters\Products\Resources\ProductResource\Pages\ManageVariants;
use Modules\Invoices\Filament\Clusters\Products\Resources\ProductResource\Pages\ViewProduct;
use Modules\Invoices\Models\Product;

class ProductResource extends BaseProductResource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $cluster = Products::class;

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewProduct::class,
            EditProduct::class,
            ManageAttributes::class,
            ManageVariants::class,
        ]);
    }

    public static function table(Table $table): Table
    {
        $table = parent::table($table);

        $filtered = collect($table->getFilters()['queryBuilder']->getConstraints())
            ->reject(fn ($constraint) => $constraint->getName() == 'responsible')
            ->all();

        $table = $table->filters([
            QueryBuilder::make()
                ->constraints($filtered),
        ]);

        return $table;
    }

    public static function getPages(): array
    {
        return [
            'index'      => ListProducts::route('/'),
            'create'     => CreateProduct::route('/create'),
            'view'       => ViewProduct::route('/{record}'),
            'edit'       => EditProduct::route('/{record}/edit'),
            'attributes' => ManageAttributes::route('/{record}/attributes'),
            'variants'   => ManageVariants::route('/{record}/variants'),
        ];
    }
}
