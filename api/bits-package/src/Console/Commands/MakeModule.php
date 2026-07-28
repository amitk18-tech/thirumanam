<?php

namespace Bits\Package\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModule extends Command
{
    protected $signature = 'make:module {name}';
    protected $description = 'Generate a complete module structure';

    public function handle()
    {
        $name = ucfirst($this->argument('name'));
        $modulePath = app_path("Modules/$name");

        if (File::exists($modulePath)) {
            $this->error("Module $name already exists!");
            return;
        }

        // Folders to create
        $folders = [
            "Http/Controllers",
            "Http/Requests",
            "Http/Resources",
            "Models",
            "Services",
            "Repositories",
            "Policies",
            "Notifications",
            "Jobs",
            "Events",
            "Listeners",
            "Exceptions",
            "Traits",
            "migrations",
            "seeders",
            "factories",
        ];

        foreach ($folders as $folder) {
            File::makeDirectory("$modulePath/$folder", 0777, true, true);
        }

        // Create stub files
        File::put("$modulePath/routes.php", $this->getRoutesStub($name));
        File::put("$modulePath/ModuleServiceProvider.php", $this->getServiceProviderStub($name));

        $this->info("Module $name generated successfully!");
    }

    protected function getRoutesStub($name)
    {
        return <<<EOT
<?php

use Illuminate\Support\Facades\Route;

Route::prefix(strtolower('$name'))->group(function () {

    // Route::get('/', [{$name}Controller::class, 'index']);

});
EOT;
    }

    protected function getServiceProviderStub($name)
    {
        return <<<EOT
<?php

namespace App\Modules\\$name;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        include __DIR__ . '/routes.php';
    }
}
EOT;
    }
}
