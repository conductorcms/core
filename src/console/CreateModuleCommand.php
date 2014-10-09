<?php namespace Mattnmoore\Conductor\Console;

use Illuminate\Console\Application;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateModuleCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'module:make';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new module.';

	/**
	 * Create a new Console Instance
	 *
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$package = $this->ask("What is the package name?");
		$module  = $this->ask("What is the module name?");
		$verison = $this->ask("What is the module version?");
		$author  = $this->ask("What is the module author's name?");

		$this->call('workbench', ['package' => $package, '--resources' => true]);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

}
