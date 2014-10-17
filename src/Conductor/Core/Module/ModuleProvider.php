<?php namespace Conductor\Core\Module;

use Illuminate\Support\ServiceProvider;
use Conductor\Core\Module\Utilities\Info;
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

        $this->app->singleton($info->name, function () use ($name, $info)
        {
            $module = $this->app->make($name);
            $module->setInfo($info);

            return $module;
        });

        $this->app->tag($info->name, 'conductor:module');

        $this->app->register(get_class($this));
    }

    public function getInfo()
    {
        $info = new Info($this);

        return $info->getModuleJson();
    }

}