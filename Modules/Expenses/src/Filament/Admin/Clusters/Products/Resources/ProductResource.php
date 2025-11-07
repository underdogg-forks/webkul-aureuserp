<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Products\Resources;

use BackedEnum;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Modules\Core\Filament\Traits\HasCustomFields;
use Modules\Core\Filament\Resources\ProductResource as BaseProductResource;
use Modules\Expenses\Filament\Admin\Clusters\Products;
use Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource\Pages\CreateProduct;
use Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource\Pages\EditProduct;
use Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource\Pages\ListProducts;
use Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource\Pages\ManageAttributes;
use Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource\Pages\ManageVariants;
use Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource\Pages\ManageVendors;
use Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource\Pages\ViewProduct;
use Modules\Expenses\Models\Product;

class ProductResource extends BaseProductResource
{
    use HasCustomFields;

    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $cluster = Products::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationLabel(): string
    {
        return __('purchases::filament/admin/clusters/products/resources/product.navigation.title');
    }

    public static function form(Schema $schema): Schema
    {
        $schema = BaseProductResource::form($schema);

        $components = $schema->getComponents();

        $schema->components($components);

        return $schema;
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

    public static function infolist(Schema $schema): Schema
    {
        $schema = BaseProductResource::infolist($schema);

        $components = $schema->getComponents();

        $schema->components($components);

        return $schema;
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewProduct::class,
            EditProduct::class,
            ManageAttributes::class,
            ManageVariants::class,
            ManageVendors::class,
        ]);
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
            'vendors'    => ManageVendors::route('/{record}/vendors'),
        ];
    }
}
