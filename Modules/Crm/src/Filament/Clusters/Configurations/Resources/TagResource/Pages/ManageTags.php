<?php

namespace Modules\Crm\Filament\Clusters\Configurations\Resources\TagResource\Pages;

use Modules\Crm\Filament\Clusters\Configurations\Resources\TagResource;
use Modules\Crm\Filament\Resources\TagResource\Pages\ManageTags as BaseManageTags;

class ManageTags extends BaseManageTags
{
    protected static string $resource = TagResource::class;
}
