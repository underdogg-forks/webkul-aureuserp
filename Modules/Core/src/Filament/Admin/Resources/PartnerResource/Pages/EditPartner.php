<?php

namespace Modules\Core\Filament\Admin\Resources\PartnerResource\Pages;

use Modules\Crm\Filament\Resources\PartnerResource\Pages\EditPartner as BaseEditPartner;
use Modules\Core\Filament\Admin\Resources\PartnerResource;

class EditPartner extends BaseEditPartner
{
    protected static string $resource = PartnerResource::class;
}
