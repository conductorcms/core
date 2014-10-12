<?php namespace Mattnmoore\Conductor\Module;

interface ModuleRepository {

	public function getAll();
    public function getAllWithAuthors();
	public function findById($id);
	public function findByName($name);
	public function createFromModuleProvider($provider);
	public function deleteByName($name);
    public function deleteAll();
	public function isInDb($name);

}