<?php

namespace Modules\Core\Filament\Admin\Resources\PartnerResource\Pages;

use Modules\Crm\Filament\Resources\PartnerResource\Pages\ManageAddresses as BaseManageAddresses;
use Modules\Core\Filament\Admin\Resources\PartnerResource;

class ManageAddresses extends BaseManageAddresses
{
    protected static string $resource = PartnerResource::class;
}
