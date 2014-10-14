<?php namespace Mattnmoore\Conductor\Module;

use Illuminate\Foundation\Artisan;
use Mattnmoore\Conductor\Module\Utilities\Info;

class Module {

    private $artisan;

	private $info;

	private $repository;

    function __construct(Artisan $artisan, Info $info, ModuleRepository $repository)
    {
        $this->artisan = $artisan;
		$this->info = $info;
		$this->repository = $repository;
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