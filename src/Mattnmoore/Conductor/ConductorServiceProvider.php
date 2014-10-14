<?php namespace Mattnmoore\Conductor;

use Illuminate\Support\ServiceProvider;
use Mattnmoore\Conductor\Console\ScanModulesCommand;
use Blade;

class ConductorServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('mattnmoore/conductor');

        $this->app->bind('Mattnmoore\Conductor\Module\ModuleRepository', 'Mattnmoore\Conductor\Module\EloquentModuleRepository');

        $conductor = $this->app->make('Mattnmoore\Conductor\Conductor');

        $conductor->boot();

        include __DIR__ . '/../../routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();
    }

    /**
     * Register commands
     *
     * @return void
     */
    public function registerCommands()
    {
        $commands = [
            'ScanModulesCommand',
            'CreateModuleCommand',
            'ListModulesCommand',
            'CompileModuleAssetsCommand',
            'CreateAdminCommand'
        ];

        $this->registerCommandsFromArray($commands);
    }

    private function registerCommandsFromArray($commands)
    {
        $namespace = 'Mattnmoore\\Conductor\\Console\\';

        foreach ($commands as $command)
        {
            $this->commands($namespace . $command);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
