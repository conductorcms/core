<?php namespace Mattnmoore\Conductor\Module;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;

abstract class ModuleProvider extends ServiceProvider {

	public function registerModule()
	{
		$reflection = new ReflectionClass($this);

		$namespace = $reflection->getNamespaceName();
		$name = ucfirst($this->info['name']);

		$name = $namespace . '\\' . $name;

		$this->app->bind($this->info['name'], function() use ($name)
		{
			return new $name();
		});

		$this->app->tag($this->info['name'], 'conductorModule');

		$this->app->register(get_class($this));

	}

}