<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Plugin;

class PluginSeeder extends Seeder
{
    public function run(): void
    {
        $packages = Plugin::getAllPluginPackages();

        foreach ($packages as $pluginName => $package) {
            if ($package->isCore) {
                continue;
            }

            // Plugin is now in Modules, composer.json path would need module mapping
            $composerPath = null; // base_path("plugins/webkul/{$pluginName}/composer.json");
            $composerData = [];
            if ($composerPath && file_exists($composerPath)) {
                $composerData = json_decode(file_get_contents($composerPath), true);
            }

            Plugin::updateOrCreate(
                ['name' => $pluginName],
                [
                    'author'         => $composerData['authors'][0]['name'] ?? 'Webkul',
                    'summary'        => $composerData['description'] ?? $package->description ?? '',
                    'description'    => $composerData['description'] ?? $package->description ?? '',
                    'latest_version' => $composerData['version'] ?? '1.0.0',
                    'license'        => $composerData['license'] ?? 'MIT',
                    'is_active'      => true,
                    'is_installed'   => false,
                    'sort'           => 1,
                ]
            );
        }
    }
}
