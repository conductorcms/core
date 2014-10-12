<?php namespace Mattnmoore\Conductor\Controllers;

use Mattnmoore\Conductor\Module\ModuleRepository;
use Illuminate\Foundation\Application;
use Response;

class ApiController {

	private $app;

	private $module;

	function __construct(ModuleRepository $module, Application $app)
	{
		$this->app = $app;
		$this->module = $module;
	}

	//return a list of modules
	public function modules()
	{
		$modules = $this->module->getAllWithAuthors();
		return Response::json(['modules' => $modules], 200);
	}

	public function installModule($id)
	{
		$module = $this->module->findById($id);

		//get Module
		$module = $this->app->make($module->name);

		//if installation is successful
		if($module->install())
		{
			return Response::json(['mesasge' => 'Module successfully installed'], 200);
		}

		return Response::json(['message' => 'This module could not be installed properly'], 500);
	}

}