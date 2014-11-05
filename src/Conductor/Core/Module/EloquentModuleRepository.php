<?php namespace Conductor\Core\Module;

class EloquentModuleRepository implements ModuleRepository {

    private $module;

    private $author;

    function __construct(Model $module, Author $author)
    {
        $this->module = $module;
        $this->author = $author;
    }

    public function getAll()
    {
        return $this->module->all();
    }

    public function getAllWithAuthors()
    {
        return $this->module->with('authors')->get();
    }

    public function getInstalled()
    {
        return $this->module->whereInstalled(true)->get();
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
        $info = $provider->getInfo();

        $module = $this->module->create((array)$info);

        $info->author->module_id = $module->id;

        $author = $this->author->create((array)$info->author);

        return true;
    }

    public function deleteByName($name)
    {
        $module = $this->findByName($name);

        return $module->delete();
    }

    public function deleteAll()
    {
        return $this->module->truncate();
    }

    public function isInDb($name)
    {
        return ($this->findByName($name) ? true : false);
    }

    public function markAsInstalled($name)
    {
        return $this->setInstalledStatus($name, true);
    }

    public function markAsUninstalled($name)
    {
        return $this->setInstalledStatus($name, false);
    }

    public function setInstalledStatus($name, $status)
    {
        $module = $this->findByName($name);

        $module->installed = $status;

        return $module->save();
    }

}