<?php

namespace Bits\Package\Providers;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $modulesPath = app_path('Modules');

        // Check if folder exists
        if (!is_dir($modulesPath)) {
            return; // stop scanning
        }

        foreach (scandir($modulesPath) as $module) {
            if ($module === '.' || $module === '..')
                continue;   

            $modulePath = $modulesPath . '/' . $module;

            // Load Routes
            if (file_exists($modulePath . '/routes/api.php')) {
                $this->loadRoutesFrom($modulePath . '/routes/api.php');
            }

            // Load Migrations
            if (is_dir($modulePath . '/database/migrations')) {
                $this->loadMigrationsFrom($modulePath . '/database/migrations');
            }

            // Load Translations (optional)
            if (is_dir($modulePath . '/resources/lang')) {
                $this->loadTranslationsFrom($modulePath . '/resources/lang', strtolower($module));
            }

            // Load Views (optional)
            if (is_dir($modulePath . '/resources/views')) {
                $this->loadViewsFrom($modulePath . '/resources/views', strtolower($module));
            }

            // Load Config (optional)
            if (file_exists($modulePath . '/config/config.php')) {
                $this->mergeConfigFrom(
                    $modulePath . '/config/config.php',
                    strtolower($module)
                );
            }
        }
    }
}
