<?php namespace Mattnmoore\Conductor\Module;

use Illuminate\Foundation\Artisan;

class Module {

    private $artisan;

    function __construct(Artisan $artisan)
    {
        $this->artisan = $artisan;
    }

	public function install()
	{
        $this->artisan->call('migrate', ['--bench' => $this->name]);

		dd('installing');
	}

	public function uninstall()
	{

	}

}