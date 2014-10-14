<?php namespace Mattnmoore\Conductor\Module\Utilities;

use Mattnmoore\Conductor\Module\Module;
use ReflectionClass;

class Info {

    private $module;

    function __construct(Module $module)
    {
        $this->module = $module;
        $this->reflection = new ReflectionClass($this->module);
    }

	public function getInfo()
	{
		$reflection = new ReflectionClass($this->module);

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