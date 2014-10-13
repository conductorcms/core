<?php namespace Mattnmoore\Conductor\Module;

use ReflectionClass;

class Info {

	public function getInfo($module)
	{
		$reflection = new ReflectionClass($module);

		$name = $reflection->getShortName();
		$path = $reflection->getFileName();

		$moduleName = preg_split('/(?=[A-Z])/', $name);
		$moduleName = strtolower($moduleName[1]);

		$info = substr($path, 0, strpos($path, $moduleName . '/'));

		$moduleRoot = $info . $moduleName . '/';

		$info = $moduleRoot . 'module.json';

		return json_decode(file_get_contents($info));
	}

	public function getModuleRoot($module)
	{

	}

}