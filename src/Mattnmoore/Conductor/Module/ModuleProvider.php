<?php namespace Mattnmoore\Conductor\Module;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;

abstract class ModuleProvider extends ServiceProvider {

	public function registerModule()
	{
		$info = $this->getInfo();

		$reflection = new ReflectionClass($this);
		$namespace = $reflection->getNamespaceName();

        $name = explode('\\', $namespace);
        $name = $name[1];

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
		$info = $this->app->make('Mattnmoore\Conductor\Module\Utilities\Info');
		return $info->getInfo($this);
	}

}