<?php namespace Mattnmoore\Conductor\Module;

use Illuminate\Foundation\Artisan;
use Mattnmoore\Conductor\Module\Utilities\Info;
use Mattnmoore\Conductor\Module\Utilities\CustomMigrator;

class Module {

    private $artisan;

    public $info;

    private $repository;

    private $migrator;

    function __construct(Artisan $artisan, ModuleRepository $repository, CustomMigrator $migrator)
    {
        $this->artisan = $artisan;
        $this->repository = $repository;
        $this->migrator = $migrator;
    }

    function setInfo($info)
    {
        $this->info = $info;
    }

    public function install()
    {
        $this->artisan->call('migrate', ['--bench' => $this->info->name]);

        $this->repository->markAsInstalled($this->info->name);

        return true;
    }

    public function uninstall()
    {
        $this->migrator->rollBackPath(base_path() . '/workbench/' . $this->info->name . '/src/migrations');

        $this->repository->markAsUninstalled($this->info->name);

        return true;
    }

}