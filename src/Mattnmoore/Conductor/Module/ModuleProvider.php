<?php namespace Mattnmoore\Conductor\Module;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;

abstract class ModuleProvider extends ServiceProvider {

	public function registerModule()
	{
		$reflection = new ReflectionClass($this);

		$info = $this->getInfo();

		$namespace = $reflection->getNamespaceName();

		$name = ucfirst($info->name);

		$name = $namespace . '\\' . $name;

		$this->app->bind($info->name, function() use ($name)
		{
			return $this->app->make($name);
		});

		$this->app->tag($info->name, 'conductor:module');

		$this->app->register(get_class($this));
	}

	public function getInfo()
	{
		$reflection = new ReflectionClass($this);

		$name = $reflection->getShortName();
		$path = $reflection->getFileName();

		$moduleName = preg_split('/(?=[A-Z])/', $name);
		$moduleName = strtolower($moduleName[1]);

		$info = substr($path, 0, strpos($path, $moduleName . '/'));

		$moduleRoot = $info . $moduleName . '/';

		$info = $moduleRoot . 'module.json';

		return json_decode(file_get_contents($info));
	}
}