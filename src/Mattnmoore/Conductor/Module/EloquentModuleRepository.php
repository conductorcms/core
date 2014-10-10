<?php namespace Mattnmoore\Conductor\Module;

class EloquentModuleRepository implements ModuleRepository {

	private $module;

	function __construct(ModuleModel $module)
	{
		$this->module = $module;
	}

	public function getAll()
	{
		return $this->module->all();
	}

	public function findById($id)
	{
		return $this->module->find($id);
	}

	public function findByName($name)
	{
		return $this->module->whereName($name)->first();
	}

	public function createFromModuleProvider($provider)
	{
		$module = $this->module->create((array) $provider->getInfo());

		return $module->save();
	}

	public function deleteByName($name)
	{
		$module = $this->findByName($name);

		return $module->delete();
	}

	public function isInDb($name)
	{
		return ($this->findByName($name) ? true : false);
	}

}