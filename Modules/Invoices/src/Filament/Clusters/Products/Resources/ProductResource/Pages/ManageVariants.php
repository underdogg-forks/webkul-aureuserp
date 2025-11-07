<?php

namespace Modules\Invoices\Filament\Clusters\Products\Resources\ProductResource\Pages;

use Modules\Core\Filament\Clusters\Vendors\Resources\ProductResource\Pages\ManageVariants as BaseManageVariants;
use Modules\Invoices\Filament\Clusters\Products\Resources\ProductResource;
use Modules\Invoices\Settings\ProductSettings;

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
