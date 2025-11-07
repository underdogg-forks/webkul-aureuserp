<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\ProductCategoryResource\Pages;

use Modules\Core\Filament\Actions as ChatterActions;
use Modules\Core\Filament\Clusters\Configuration\Resources\ProductCategoryResource;
use Modules\Core\Filament\Resources\CategoryResource\Pages\EditCategory;
use Modules\Core\Traits\HasRecordNavigationTabs;

class EditProductCategory extends EditCategory
{
    use HasRecordNavigationTabs;

    protected static string $resource = ProductCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ChatterActions\ChatterAction::make()
                ->setResource(static::$resource),
            ...parent::getHeaderActions(),
        ];
    }
}
