<?php namespace Conductor\Core;

use Illuminate\Cache\Repository as Cache;
use Illuminate\Config\Repository as Config;
use Illuminate\Foundation\Application;
use Illuminate\View\Factory;
use Conductor\Core\Module\ModuleRepository;

class Conductor {

    /**
     * @var Application
     */
    private $app;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var
     */
    private $module;

    /**
     * @var
     */
    private $view;

    function __construct(Application $app, Cache $cache, Config $config, ModuleRepository $module, Factory $view)
    {
        $this->app = $app;
        $this->cache = $cache;
        $this->config = $config;
        $this->module = $module;
        $this->view = $view;
    }

    /**
     *
     */
    public function boot()
    {
        $this->registerModules();
		$this->registerWidgets();
        $this->registerTheme();
    }

    public function registerModules()
    {
        //get module providers from config
        $moduleProviders = $this->config->get('core::modules');

        //register modules in tagged container
        foreach ($moduleProviders as $module)
        {
            $module = new $module($this->app->make('app'));
            $module->registerModule();
        }
    }

	private function registerWidgets()
	{
		$widgets = $this->config->get('core::widgets');

		foreach($widgets as $widget)
		{
			$widget = $this->app->make($widget);
			$widget->register();
		}
	}

    public function registerTheme()
    {
        $theme = $this->config->get('core::themes.active');
        $path = base_path() . '/' . $this->config->get('core::themes.dir');

        $this->view->addLocation($path);
        $this->view->addNamespace($theme, $path);
    }

    public function scanModules($refresh = false)
    {
        //delete all registered modules if refresh flag is set
        if($refresh) $this->module->deleteAll();

        //delete cache
        $this->cache->forget('registeredModules');

        //retrieve all registered modules
        $registeredModules = $this->getRegisteredModules();

        //get module provider names from config
        $moduleProviders = $this->config->get('core::modules');

        //sync the providers in the config with the registered modules
        $this->syncModules($moduleProviders, $registeredModules);
    }

    private function getRegisteredModules()
    {
        //get modules registered in DB
        return $this->cache->rememberForever('registeredModules', function ()
        {
            return $this->module->getAll();
        });
    }

    private function syncModules($providers, $registered)
    {
        //module names for checking against DB
        $moduleNames = [];

        //add new modules from config to DB
        foreach ($providers as $provider)
        {
            //resolve provider
            $provider = new $provider($this->app->make('app'));

            //store name
            $info = $provider->getInfo();

            $moduleNames[] = $info->name;

            //if it's not in the DB, add it
            if(!$this->module->isInDb($info->name)) $this->module->createFromModuleProvider($provider);
        }

        //Sync config module removals to DB
        foreach ($registered as $module)
        {
            if(!in_array($module->name, $moduleNames)) $this->module->deleteByName($module->name);
        }
    }


}