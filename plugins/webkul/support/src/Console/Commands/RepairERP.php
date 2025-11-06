<?php

namespace Webkul\Support\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Throwable;

class RepairERP extends Command
{
    protected $signature = 'erp:repair';

    protected $description = 'Repair ERP installation by installing any plugins marked as not installed and ensuring their seeders and settings migrations are executed.';

    public function handle(): int
    {
        $this->info('Starting ERP repair...');

        if ( ! $this->pluginsTableExists()) {
            $this->error('The plugins table does not exist yet. Run migrations first.');

            return self::FAILURE;
        }

        $notInstalled = DB::table('plugins')->where('is_installed', false)->pluck('name');

        if ($notInstalled->isEmpty()) {
            $this->info('All plugins are already marked as installed. Nothing to repair.');

            return self::SUCCESS;
        }

        foreach ($notInstalled as $plugin) {
            $lower = Str::of($plugin)->lower()->toString();
            $this->components->twoColumnDetail("Installing {$lower}", '...');

            // Run the plugin installer command if it exists
            try {
                $this->callSilentIfExists("{$lower}:install");
            } catch (Throwable $e) {
                dd($e->getMessage());
            }

            // Run settings migrations for that plugin explicitly
            $this->runPluginSettingsMigrations($lower);

            // Try to run the plugin's main database seeder
            $this->runPluginSeeder($lower);

            $this->components->twoColumnDetail("Installed {$lower}", 'DONE');
        }

        $this->newLine();
        $this->info('✅ ERP repair finished.');

        return self::SUCCESS;
    }

    protected function pluginsTableExists(): bool
    {
        try {
            return DB::getSchemaBuilder()->hasTable('plugins');
        } catch (Throwable) {
            return false;
        }
    }

    protected function runPluginSettingsMigrations(string $lowerName): void
    {
        $basePath = base_path("plugins/webkul/{$lowerName}/database/settings");
        if ( ! File::isDirectory($basePath)) {
            return;
        }

        $files = collect(File::files($basePath))
            ->filter(fn ($f) => Str::endsWith($f->getFilename(), '.php'))
            ->map(fn ($f) => Str::after($f->getPathname(), base_path() . DIRECTORY_SEPARATOR));

        foreach ($files as $relative) {
            // run: php artisan migrate --path=relative
            try {
                $this->callSilent('migrate', [
                    '--path' => $relative,
                ]);
            } catch (Throwable $e) {
                dd($e->getMessage());
            }
        }
    }

    protected function runPluginSeeder(string $lowerName): void
    {
        // Best effort: attempt to run the conventional DatabaseSeeder of the plugin
        $studly      = Str::studly(str_replace(['-', '_'], ' ', $lowerName));
        $seederClass = "Webkul\\{$studly}\\Database\\Seeders\\DatabaseSeeder";

        try {
            if (class_exists($seederClass)) {
                $this->callSilent('db:seed', [
                    '--class' => $seederClass,
                ]);
            }
        } catch (Throwable $e) {
            dd($e->getMessage());
        }
    }

    protected function callSilentIfExists(string $command): void
    {
        // Check if command exists within Artisan
        try {
            $commands = collect(Artisan::all())->keys();
            if ($commands->contains($command)) {
                $this->callSilent($command);
            }
        } catch (Throwable) {
            dd($e->getMessage());
        }
    }
}
