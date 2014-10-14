<?php namespace Mattnmoore\Conductor\Module\Utilities;

use ReflectionClass;

class Info
{

    private $provider;

    private $reflection;

    function __construct($provider)
    {
        $this->provider = $provider;
        $this->reflection = new ReflectionClass($this->provider);
    }

    public function getInfo()
    {
        $reflection = $this->reflection;

        $name = $reflection->getShortName();
        $path = $reflection->getFileName();

        $moduleName = preg_split('/(?=[A-Z])/', $name);
        $moduleName = strtolower($moduleName[1]);

        $info = substr($path, 0, strpos($path, $moduleName . '/'));

        $moduleRoot = $info . $moduleName . '/';

        $info = $moduleRoot . 'module.json';

        return json_decode(file_get_contents($info));
    }

    public function getModuleRoot()
    {

    }

    public function getNamespace()
    {

    }

    public function getClassName()
    {

    }

    public function getPackageName()
    {

    }

}