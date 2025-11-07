<?php

namespace Modules\Core\Filament\Admin\Resources\PartnerResource\Pages;

use Modules\Crm\Filament\Resources\PartnerResource\Pages\ListPartners as BaseListPartners;
use Modules\Core\Filament\Admin\Resources\PartnerResource;

class ListPartners extends BaseListPartners
{
    protected static string $resource = PartnerResource::class;
}
