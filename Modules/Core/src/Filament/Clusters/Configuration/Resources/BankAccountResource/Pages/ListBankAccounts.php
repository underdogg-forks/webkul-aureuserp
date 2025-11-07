<?php

namespace Modules\Core\Filament\Clusters\Configuration\Resources\BankAccountResource\Pages;

use Modules\Core\Filament\Resources\BankAccountResource\Pages\ListBankAccounts as BaseManageBankAccounts;
use Modules\Core\Filament\Clusters\Configuration\Resources\BankAccountResource;

class ListBankAccounts extends BaseManageBankAccounts
{
    protected static string $resource = BankAccountResource::class;
}
