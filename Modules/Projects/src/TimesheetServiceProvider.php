<?php

namespace Modules\Projects;

use Modules\Core\Console\Commands\InstallCommand;
use Modules\Core\Console\Commands\UninstallCommand;
use Modules\Core\Package;
use Modules\Core\PackageServiceProvider;

class TimesheetServiceProvider extends PackageServiceProvider
{
    public static string $name = 'timesheets';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasTranslations()
            ->hasDependencies([
                'projects',
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->installDependencies();
            })
            ->hasUninstallCommand(function (UninstallCommand $command) {})
            ->icon('timesheet');
    }

    public function packageBooted(): void {}
}
