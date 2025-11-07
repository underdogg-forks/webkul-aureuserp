<?php

namespace Modules\Core\Filament\Admin\Resources\PartnerResource\Pages;

use Modules\Crm\Filament\Resources\PartnerResource\Pages\CreatePartner as BaseCreatePartner;
use Modules\Core\Filament\Admin\Resources\PartnerResource;

class CreatePartner extends BaseCreatePartner
{
    protected static string $resource = PartnerResource::class;
}
