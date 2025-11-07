<?php

namespace Modules\Crm\Filament\Clusters\Configurations\Resources\BankResource\Pages;

use Modules\Crm\Filament\Clusters\Configurations\Resources\BankResource;
use Modules\Crm\Filament\Resources\BankResource\Pages\ManageBanks as BaseManageBanks;

class ManageBanks extends BaseManageBanks
{
    protected static string $resource = BankResource::class;
}
