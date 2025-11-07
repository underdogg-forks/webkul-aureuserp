<?php

namespace Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource\Pages;

use Modules\Core\Filament\Resources\ProductResource\Pages\ManageAttributes as BaseManageAttributes;
use Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource;
use Modules\Expenses\Settings\ProductSettings;

class ManageAttributes extends BaseManageAttributes
{
    protected static string $resource = ProductResource::class;

    /**
     * @param array<string, mixed> $parameters
     */
    public static function canAccess(array $parameters = []): bool
    {
        $canAccess = parent::canAccess($parameters);

        if ( ! $canAccess) {
            return false;
        }

        return app(ProductSettings::class)->enable_variants;
    }
}
