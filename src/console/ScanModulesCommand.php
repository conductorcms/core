<?php namespace Mattnmoore\Conductor\Console;

use Illuminate\Console\Application;
use Illuminate\Foundation\Application as App;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Mattnmoore\Conductor\Conductor;

class ScanModulesCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'module:scan';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Scan for new modules.';

	/**
	 * Create a new Console Instance
	 *
	 * @param App $app
	 */
	public function __construct(App $app)
	{
		$this->app = $app;

		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$conductor = $this->app->make('Mattnmoore\Conductor\Conductor');

		return $this->info($conductor->scanModules($this->option('refresh')));
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
		return [
            ['refresh', null, InputOption::VALUE_NONE, 'Delete all module records and re-scan', null]
        ];
	}

}
