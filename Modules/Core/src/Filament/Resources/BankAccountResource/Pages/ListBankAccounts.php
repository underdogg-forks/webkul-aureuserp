<?php

namespace Modules\Core\Filament\Resources\BankAccountResource\Pages;

use Modules\Core\Filament\Resources\BankAccountResource;
use Modules\Crm\Filament\Resources\BankAccountResource\Pages\ManageBankAccounts as BaseManageBankAccounts;

class ListBankAccounts extends BaseManageBankAccounts
{
    protected static string $resource = BankAccountResource::class;
}
