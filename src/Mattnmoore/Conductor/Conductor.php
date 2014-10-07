<?php namespace Mattnmoore\Conductor;

use Config, App;

class Conductor {

	public $modules = [];

	public function boot()
	{
		$modules = Config::get('conductor::modules');

		foreach($modules as $module)
		{
			$module = new $module(App::make('app'));
			$module->registerModule();
		}

	}

}