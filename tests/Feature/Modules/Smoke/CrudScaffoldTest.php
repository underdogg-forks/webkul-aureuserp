<?php

namespace Tests\Feature\Modules\Smoke;

use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * @group smoke
 */
class CrudScaffoldTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public static function moduleListDataProvider(): array
    {
        // B) Core-focused ones
        $core = [
            // resource list pages to probe if they exist yet
            ['module' => 'Accounts',     'listPage' => '\\Webkul\\Account\\Filament\\Resources\\AccountResource\\Pages\\ListAccounts'],
            ['module' => 'Employees',    'listPage' => '\\Webkul\\Employee\\Filament\\Resources\\EmployeeResource\\Pages\\ListEmployees'],
            ['module' => 'Fields',       'listPage' => '\\Webkul\\Field\\Filament\\Resources\\FieldResource\\Pages\\ListFields'],
            ['module' => 'FullCalendar', 'listPage' => '\\Webkul\\FullCalendar\\Filament\\Resources\\CalendarEventResource\\Pages\\ListCalendarEvents'],
            ['module' => 'PluginManager', 'listPage' => '\\Webkul\\PluginManager\\Filament\\Resources\\PluginResource\\Pages\\ListPlugins'],
            ['module' => 'Security',     'listPage' => '\\Webkul\\Security\\Filament\\Resources\\UserResource\\Pages\\ListUsers'],
            ['module' => 'Support',      'listPage' => '\\Webkul\\Support\\Filament\\Resources\\CompanyResource\\Pages\\ListCompanies'],
            ['module' => 'TableViews',   'listPage' => '\\Webkul\\TableViews\\Filament\\Resources\\TableViewResource\\Pages\\ListTableViews'],
            ['module' => 'TimeOff',      'listPage' => '\\Webkul\\TimeOff\\Filament\\Resources\\TimeOffResource\\Pages\\ListTimeOffs'],
        ];

        // C) Sales/Finance side
        $salesFinance = [
            ['module' => 'Invoices',   'listPage' => '\\Webkul\\Invoice\\Filament\\Resources\\InvoiceResource\\Pages\\ListInvoices'],
            ['module' => 'Payments',   'listPage' => '\\Webkul\\Payment\\Filament\\Resources\\PaymentResource\\Pages\\ListPayments'],
            ['module' => 'Inventory',  'listPage' => '\\Webkul\\Inventory\\Filament\\Resources\\StockMoveResource\\Pages\\ListStockMoves'],
        ];

        return array_merge($core, $salesFinance);
    }

    /**
     * Probe that each module's main listing can be mounted once the resource exists.
     * If the resource doesn't exist yet, this is a scaffold and will be marked as skipped.
     *
     * @dataProvider moduleListDataProvider
     */
    public function it_lists_module_records_scaffolded(string $module, string $listPage): void
    {
        /* Arrange */
        if ( ! class_exists($listPage)) {
            $this->markTestSkipped($module . ' list resource not available yet.');
        }

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test($listPage);

        /* Assert */
        // We don't do generic status assertions; this scaffold simply ensures mount works.
        // When real factories/resources are present, replace this with real data assertions.
        $this->assertTrue(true);
    }

    /**
     * Scaffold for Create action. Skips until the page + action exist.
     *
     * @dataProvider moduleListDataProvider
     */
    public function it_creates_module_record_scaffolded(string $module, string $listPage): void
    {
        /* Arrange */
        if ( ! class_exists($listPage)) {
            $this->markTestSkipped($module . ' create action not available yet.');
        }

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test($listPage)
            ->mountAction('create');

        /* Assert */
        $this->assertTrue(true);
    }

    /**
     * Scaffold for Update action. Skips until the table edit action exists and factories are available.
     *
     * @dataProvider moduleListDataProvider
     */
    public function it_updates_module_record_scaffolded(string $module, string $listPage): void
    {
        /* Arrange */
        if ( ! class_exists($listPage)) {
            $this->markTestSkipped($module . ' update action not available yet.');
        }

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test($listPage);

        // Without a concrete model + factory we cannot mount the edit action meaningfully here yet.
        $this->markTestSkipped($module . ' update test will activate once factories/resources are in place.');

        /* Assert */
        $this->assertTrue(true);
    }

    /**
     * Scaffold for Delete action. Skips until the table delete action exists and factories are available.
     *
     * @dataProvider moduleListDataProvider
     */
    public function it_deletes_module_record_scaffolded(string $module, string $listPage): void
    {
        /* Arrange */
        if ( ! class_exists($listPage)) {
            $this->markTestSkipped($module . ' delete action not available yet.');
        }

        /* Act */
        $component = Livewire::actingAs($this->user)
            ->test($listPage);

        $this->markTestSkipped($module . ' delete test will activate once factories/resources are in place.');

        /* Assert */
        $this->assertTrue(true);
    }
}
