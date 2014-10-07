<?php namespace Mattnmoore\Conductor\Module;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;

class Module extends ServiceProvider {

	public function register()
	{

	}

	public function registerModule()
	{
		$reflection = new ReflectionClass($this);

		$namespace = $reflection->getNamespaceName();
		$name = ucfirst($this->name);

		$name = $namespace . '\\' . $name;

		$this->app->bind($this->name, function() use ($name)
		{
			return new $name();
		});

		$this->app->tag($this->name, 'conductorModule');
	}

}