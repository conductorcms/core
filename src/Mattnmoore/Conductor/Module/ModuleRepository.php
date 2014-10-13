<?php namespace Mattnmoore\Conductor\Module;

interface ModuleRepository {

	public function getAll();
    public function getAllWithAuthors();
    public function getInstalled();
	public function findById($id);
	public function findByName($name);
	public function createFromModuleProvider($provider);
	public function deleteByName($name);
    public function deleteAll();
	public function isInDb($name);
	public function markAsInstalled($name);
	public function markAsUninstalled($name);
}