<?php namespace Conductor\Core\Http\Controllers;

use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Conductor\Core\Module\ModuleRepository;
use Illuminate\Foundation\Application;
use Response;
use Route;

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
        $moduleModel = $this->module->findById($id);

        //get Module
        $module = $this->app->make($moduleModel->name);

        //if installation is successful
        if($module->install())
        {
            $moduleModel->installed = true;
            return Response::json(['mesasge' => 'Module successfully installed', 'module' => $moduleModel], 200);
        }

        return Response::json(['message' => 'This module could not be installed properly'], 500);
    }

    public function uninstallModule($id)
    {
        $moduleModel = $this->module->findById($id);

        //get Module
        $module = $this->app->make($moduleModel->name);

        //if uninstallation is successful
        if($module->uninstall())
        {
            $moduleModel->installed = false;
            return Response::json(['mesasge' => 'Module successfully uninstalled', 'module' => $moduleModel], 200);
        }

        return Response::json(['message' => 'This module could not be uninstalled properly'], 500);
    }

    function routes()
    {
        $routes = Route::getRoutes();

        $friendlyRoutes = [];

        foreach($routes as $route)
        {
            $new['http'] = $route->getMethods()[0];
            $new['route'] = $route->getPath();
            $new['action'] = $route->getActionName();

            $friendlyRoutes[] = $new;
        }

        return $friendlyRoutes;
    }

}