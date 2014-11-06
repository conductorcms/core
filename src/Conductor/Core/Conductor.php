<?php namespace Conductor\Core;

use Illuminate\Cache\Repository as Cache;
use Illuminate\Config\Repository as Config;
use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Factory;
use Conductor\Core\Module\ModuleRepository;

class Conductor {

    /**
     * @var Application
     */
    private $app;

    /**
     * @var BladeCompiler
     */
    private $blade;

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

    function __construct(Application $app, BladeCompiler $blade, Cache $cache, Config $config, ModuleRepository $module, Factory $view)
    {
        $this->app = $app;
        $this->blade = $blade;
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
        $this->registerWidgetBladeExtensions();
        $this->registerTheme();
    }

    public function registerModules()
    {
        //get module providers from config
        $moduleProviders = $this->config->get('core::conductor.modules');

        //register modules in tagged container
        foreach ($moduleProviders as $module)
        {
            $module = new $module($this->app->make('app'));
            $module->registerModule();
        }
    }

    private function registerWidgets()
    {
        $widgets = $this->config->get('core::conductor.widgets');

        foreach ($widgets as $widget)
        {
            $widget = $this->app->make($widget);

            $this->app->bind('conductor:widget:' . $widget->slug, function () use ($widget)
            {
                return $widget;
            });

            $widget->register();
            $viewPath = $this->getWidgetViewPath($widget);
            $this->view->addNamespace('widget.' . $widget->slug, $viewPath);

        }

        $this->registerWidgetBladeExtensions();
    }

    private function getWidgetViewPath($widget)
    {
        $reflection = new \ReflectionClass($widget);
        $path = $reflection->getFileName();

        $pieces = explode('/', $path);

        $pieces[count($pieces) - 1] = 'views/';

        return implode('/', $pieces);
    }

    public function registerWidgetBladeExtensions()
    {
        $handler = $this->app->make('Conductor\Core\Widget\CustomBladeTags');

        $handler->registerAll();
    }

    public function registerTheme()
    {
        $theme = $this->config->get('core::conductor.themes.active');
        $path = base_path() . '/' . $this->config->get('core::conductor.themes.dir') . '/' . $theme;

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
        $moduleProviders = $this->config->get('core::conductor.modules');

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