<?php

namespace Modules\Products\Filament\Clusters\Products\Resources\ProductResource\Pages;

use Modules\Products\Filament\Clusters\Products\Resources\ProductResource;
use Modules\Products\Settings\ProductSettings;
use Modules\Core\Filament\Resources\ProductResource\Pages\ManageVariants as BaseManageVariants;

class ManageVariants extends BaseManageVariants
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
