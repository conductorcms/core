<?php namespace Mattnmoore\Conductor;

use Illuminate\Cache\Repository as Cache;
use Illuminate\Config\Repository as Config;
use Illuminate\Foundation\Application;
use Mattnmoore\Conductor\Module\ModuleRepository;

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

	function __construct(Application $app, Cache $cache, Config $config, ModuleRepository $module)
	{
		$this->app = $app;
		$this->cache = $cache;
		$this->config = $config;
		$this->module = $module;
	}

	/**
	 *
	 */
	public function boot()
	{
		$this->registerModules();
	}

	public function registerModules()
	{
		//get module providers from config
		$moduleProviders = $this->config->get('conductor::modules');

		//register modules in tagged container
		foreach($moduleProviders as $module)
		{
			$module = new $module($this->app->make('app'));
			$module->registerModule();
		}
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
		$moduleProviders = $this->config->get('conductor::modules');

		//sync the providers in the config with the registered modules
		$this->syncModules($moduleProviders, $registeredModules);
	}

	private function getRegisteredModules()
	{
		//get modules registered in DB
		return $this->cache->rememberForever('registeredModules', function()
		{
			return $this->module->getAll();
		});
	}

	private function syncModules($providers, $registered)
	{
		//module names for checking against DB
		$moduleNames = [];

		//add new modules from config to DB
		foreach($providers as $provider)
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
		foreach($registered as $module)
		{
			if(!in_array($module->name, $moduleNames)) $this->module->deleteByName($module->name);
		}
	}



}