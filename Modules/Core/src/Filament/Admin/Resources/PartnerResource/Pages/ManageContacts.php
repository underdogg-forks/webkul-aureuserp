<?php

namespace Modules\Core\Filament\Admin\Resources\PartnerResource\Pages;

use Modules\Crm\Filament\Resources\PartnerResource\Pages\ManageContacts as BaseManageContacts;
use Modules\Core\Filament\Admin\Resources\PartnerResource;

class ManageContacts extends BaseManageContacts
{
    protected static string $resource = PartnerResource::class;
}
