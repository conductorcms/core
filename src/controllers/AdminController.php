<?php namespace Mattnmoore\Conductor\Controllers;

use Mattnmoore\Conductor\Module\ModuleRepository;
use View;

class AdminController {

	private $module;

	function __construct(ModuleRepository $module)
	{
		$this->module = $module;
	}

	public function index()
	{
        $modules = ['battletracker'];

        foreach($modules as &$module)
        {
            $module = 'admin.' . $module;
        }

        $data['modules'] = $modules;

        return View::make('conductor::admin.index', $data);
	}

	public function modules()
	{
		$data['modules'] = $this->module->getAll();

		foreach($data['modules'] as $module)
		{
			$module->installed = ($module->installed ? 'Yes' : 'No');
		}

		return View::make('conductor::admin.modules', $data);
	}

	public function moduleAdmin($slug)
	{
		$module = $this->module->findByName($slug);

		$name = $module->name . '::admin.index';

		return View::make($name);
	}

}