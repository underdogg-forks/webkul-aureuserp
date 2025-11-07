<?php

namespace Modules\Crm\Filament\Clusters\Configurations\Resources\BankAccountResource\Pages;

use Modules\Crm\Filament\Clusters\Configurations\Resources\BankAccountResource;
use Modules\Crm\Filament\Resources\BankAccountResource\Pages\ManageBankAccounts as BaseManageBankAccounts;

class ManageBankAccounts extends BaseManageBankAccounts
{
    protected static string $resource = BankAccountResource::class;
}
