<?php namespace Mattnmoore\Conductor\Console;

use Illuminate\Console\Application;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Filesystem\Filesystem;

class CreateModuleCommand extends Command {

	protected $files;
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
	 * @param Filesystem $files
	 */
	public function __construct(Filesystem $files)
	{
		$this->files = $files;

		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$module = $this->getModuleInfo();

		$this->info('Making workbench package');

		//make package
		$this->call('workbench', ['package' => $module['name'], '--resources' => true]);

		$basePath = base_path() . '/workbench/' . $module['name'] . '/';

		$this->info('Generating module files');
		//generate module.json
		$this->files->put($basePath . 'modules.json', json_encode($module, JSON_PRETTY_PRINT));

		$this->info('Generating angular module skeleton');
		//generate admin angular app skeleton
		$this->files->makeDirectory($basePath . 'resources');
		$this->files->makeDirectory($basePath . 'resources/views/');
		$this->files->makeDirectory($basePath . 'resources/js/');
		$this->files->makeDirectory($basePath . 'resources/js/controllers');
		$this->files->makeDirectory($basePath . 'resources/js/services');
		$this->files->makeDirectory($basePath . 'resources/js/filters');
		$this->files->makeDirectory($basePath . 'resources/js/directives');

		//generate base angular app
		$appSkeleton = $this->files->get(__DIR__ . '/resources/app.skeleton.js');

		$parts = explode('/', $module['name']);
		$name = $parts[1];
		$className = ucfirst($name);
		$namespace = ucfirst($parts[0]);

		$appSkeleton = str_replace('##module_name##', $name, $appSkeleton);
		$appSkeleton = str_replace('##module_package##', $module['name'], $appSkeleton);
		$appSkeleton = str_replace('##module_display_name##', $module['display_name'], $appSkeleton);

		$this->files->put($basePath . 'resources/js/' . $name . '.js', $appSkeleton);

		//generate base angular controller
		$controllerSkeleton = $this->files->get(__DIR__ . '/resources/controller.skeleton.js');

		$controllerSkeleton = str_replace('##module_name##', $name, $controllerSkeleton);
		$controllerSkeleton = str_replace('##module_package##', $module['name'], $controllerSkeleton);
		$controllerSkeleton = str_replace('##module_display_name##', $module['display_name'], $controllerSkeleton);

		$this->files->put($basePath . 'resources/js/controllers/' . $module['display_name'] . 'Ctrl.js', $controllerSkeleton);

		$this->files->makeDirectory($basePath . 'public/assets');
		$this->files->makeDirectory($basePath . 'public/assets/views');
		$this->files->copy(__DIR__ . '/resources/view.skeleton.html', $basePath . '/public/assets/views/index.html');

		$this->info('Generating Module Provider');
		$providerPath = $basePath . 'src/' . $namespace . '/' . $className . '/' . $className;
		$this->files->move($providerPath . 'ServiceProvider.php', $providerPath . 'ModuleProvider.php');

		$this->info('Adding to module provider config');
	}

	private function getModuleInfo()
	{
		$module['name'] = $this->ask("What is the package name? (E.g. mattnmoore/conductor)");
		$module['display_name']  = $this->ask("What is the module's name?");
		$module['version'] = $this->ask("What is the module's version?");
		$module['description'] = $this->ask("What is the module's description?");

		$backend = $this->ask("Will this module have a back-end component? (Y or N)");
		$module['backend'] = ($backend == 'Y' || $backend == 'y' ? true : false);

		$frontend = $this->ask("Will this module have a back-end component? (Y or N)");
		$module['frontend'] = ($frontend == 'Y' || $frontend == 'y' ? true : false);

		$module['authors'] = [];
		$multipleAuthors  = $this->ask("Are there multiple authors? (Y or N)");
		if($multipleAuthors == 'Y' || $multipleAuthors == 'y')
		{
			$numberofAuthors = $this->ask("How many? (1, 2, 3...");
			foreach(range(1, $numberofAuthors) as $author)
			{
				$newAuthor = [];
				$newAuthor['name'] = $this->ask("What is author #$author's name?");
				$newAuthor['email'] = $this->ask("What is author #$author's email?");
				$module['authors'][] = $newAuthor;
			}
		}
		else
		{
			$author['name'] = $this->ask("What is the author's name?");
			$author['email'] = $this->ask("What is the author's email?");
			$module['authors'][] = $author;
		}

		//register default assets
		$module['assets'] = [];

		$module['assets']['js'] = [
			'resources/js/**/*.js'
		];

		return $module; 
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
