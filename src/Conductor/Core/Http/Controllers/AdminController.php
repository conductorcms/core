<?php namespace Conductor\Core\Http\Controllers;

use Conductor\Core\Module\ModuleRepository;
use Illuminate\Routing\Controller;
use View;

class AdminController extends Controller {

    private $module;

    function __construct(ModuleRepository $module)
    {
        $this->module = $module;
    }

    public function index()
    {
        $modules = $this->module->getInstalled();
        $names = [];

        foreach ($modules as $module)
        {
            $parts = explode('/', $module->name);

            $names[] = 'admin.' . strtolower($parts[1]);
        }

        $data['modules'] = $names;

        return View::make('core::admin.index', $data);
    }

    public function login()
    {
        return View::make('core::admin.login');
    }

    public function modules()
    {
        $data['modules'] = $this->module->getAll();

        foreach ($data['modules'] as $module)
        {
            $module->installed = ($module->installed ? 'Yes' : 'No');
        }

        return View::make('core::admin.modules', $data);
    }

    public function moduleAdmin($slug)
    {
        $module = $this->module->findByName($slug);

        $name = $module->name . '::admin.index';

        return View::make($name);
    }

}