<?php namespace Conductor\Core;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Conductor\Core\Console\ScanModulesCommand;
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
        $this->package('conductor/core');

        $this->app->bind('Conductor\Core\Module\ModuleRepository', 'Conductor\Core\Module\EloquentModuleRepository');
		$this->app->bind('Conductor\Core\Widget\WidgetRepository', 'Conductor\Core\Widget\EloquentWidgetRepository');

		$this->registerMigratorBindings();

        $conductor = $this->app->make('Conductor\Core\Conductor');

        $conductor->boot();

		include __DIR__ . '/../../helpers.php';
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
            'CreateAdminCommand',
            'InstallCommand'
        ];

        $this->registerCommandsFromArray($commands);
    }

    private function registerCommandsFromArray($commands)
    {
        $namespace = 'Conductor\\Core\\Console\\';

        foreach ($commands as $command)
        {
            $this->commands($namespace . $command);
        }
    }

	private function registerMigratorBindings()
	{
		$this->app->bind('Illuminate\Database\Migrations\MigrationRepositoryInterface', function()
		{
			return new DatabaseMigrationRepository($this->app->make('db'), 'migrations');
		});
		$this->app->bind('Illuminate\Database\ConnectionResolverInterface', 'Illuminate\Database\ConnectionResolver');
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
