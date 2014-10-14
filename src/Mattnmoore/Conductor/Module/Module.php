<?php namespace Mattnmoore\Conductor\Module;

use Illuminate\Foundation\Artisan;
use Mattnmoore\Conductor\Module\Utilities\Info;

class Module {

    private $artisan;

	public $info;

	private $repository;

    function __construct(Artisan $artisan, ModuleRepository $repository)
    {
        $this->artisan = $artisan;
		$this->repository = $repository;
    }

    function setInfo($info)
    {
        $this->info = $info;
    }

	public function install()
	{
		$info = $this->info->getInfo($this);

		$this->artisan->call('migrate', ['--bench' => $info->name]);

		$this->repository->markAsInstalled($info->name);

		return true;
	}

	public function uninstall()
	{
		$info = $this->info->getInfo($this);

		$this->artisan->call('migrate:reset', ['--bench' => $info->name]);

		$this->repository->markAsUninstalled($info->name);

		return true;
	}

}