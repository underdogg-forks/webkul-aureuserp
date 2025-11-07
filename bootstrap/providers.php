<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    App\Providers\Filament\CustomerPanelProvider::class,
    Modules\Core\Providers\CoreServiceProvider::class,
    Modules\Crm\Providers\CrmServiceProvider::class,
    Modules\Products\Providers\ProductsServiceProvider::class,
    Modules\Payments\Providers\PaymentsServiceProvider::class,
    Modules\Projects\Providers\ProjectsServiceProvider::class,
    Modules\Expenses\Providers\ExpensesServiceProvider::class,
    Modules\Invoices\Providers\InvoicesServiceProvider::class,
    Modules\Quotes\Providers\QuotesServiceProvider::class,
];
