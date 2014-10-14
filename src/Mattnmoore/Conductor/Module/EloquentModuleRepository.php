<?php namespace Mattnmoore\Conductor\Module;

class EloquentModuleRepository implements ModuleRepository
{

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
        $info = $provider->getInfo();

        $module = $this->module->create((array)$info);

        $authors = [];
        foreach ($info->authors as $author) {
            $author = $this->author->create((array)$author);
            $authors[] = $author;
        }

        $module->save();

        $module->authors()->saveMany($authors);

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

    public function setInstalledStatus($name, $status)
    {
        $module = $this->findByName($name);

        $module->installed = $status;

        return $module->save();
    }

    public function markAsInstalled($name)
    {
        return $this->setInstalledStatus($name, true);
    }

    public function markAsUninstalled($name)
    {
        return $this->setInstalledStatus($name, false);
    }

}