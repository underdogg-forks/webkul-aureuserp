<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\IncoTermResource\Pages;

use Modules\Core\Filament\Resources\IncoTermResource\Pages\ListIncoTerms as BaseListIncoTerms;
use Modules\Core\Filament\Clusters\Configuration\Resources\IncoTermResource;

class ListIncoTerms extends BaseListIncoTerms
{
    protected static string $resource = IncoTermResource::class;
}
