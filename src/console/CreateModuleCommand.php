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
		$this->files->put($basePath . 'module.json', json_encode($module, JSON_PRETTY_PRINT));

		$this->info('Generating angular module skeleton');

		$directories = $this->getDirectories();
		$this->createDirectoriesFromArray($directories, $basePath);

		//generate base angular app
		$parts = explode('/', $module['name']);
		$name = $parts[1];

		$data['name'] = $name;
		$data['package_name'] = $module['name'];
		$data['display_name'] = $module['display_name'];
        $data['namespace']    = ucfirst($parts[0]);
        $data['className']    = ucfirst($parts[1]);

        $skeleton = $this->getSkeleton(__DIR__ . '/resources/app.skeleton.js', $data);
		$this->files->put($basePath . 'resources/js/' . $name . '.js', $skeleton);

		//generate base angular controller
		$skeleton = $this->getSkeleton(__DIR__ . '/resources/controller.skeleton.js', $data);
		$this->files->put($basePath . 'resources/js/controllers/' . $data['display_name'] . 'Ctrl.js', $skeleton);

		$this->files->copy(__DIR__ . '/resources/view.skeleton.html', $basePath . 'public/assets/views/index.html');

        $this->info('Generating Module Provider');

        $providerPath = $basePath . 'src/' . $data['namespace'] . '/' . $data['className'] . '/' . $data['className'];

        $this->files->delete($providerPath . 'ServiceProvider.php');

        $skeleton = $this->getSkeleton(__DIR__ . '/resources/provider.skeleton', $data);
        $this->files->put($providerPath . 'ModuleProvider.php', $skeleton);

        $this->info('Generating Module');

        $skeleton = $this->getSkeleton(__DIR__ . '/resources/module.skeleton', $data);
        $this->files->put($providerPath . '.php', $skeleton);

        $this->info('Adding to module provider config');

        //Add new provider to the provider list
        $file = base_path() . '/workbench/mattnmoore/conductor/src/config/modules.php';
        $fh = fopen($file, 'r+');
        $provider = "    '" . $data['namespace'] . "\\" . $data['className'] . "\\" . $data['className'] . "ModuleProvider'," . PHP_EOL . '];';
        fseek($fh, -2, SEEK_END);
        fwrite($fh, $provider);
        fclose($fh);

        //add empty routes file
        $this->files->put($basePath . '/src/routes.php', '');

        $this->call('dump-autoload');
        $this->call('publish:assets', ['--bench' => $data['package_name']]);
	}

	private function getModuleInfo()
	{
		$module['name'] = $this->ask("What is the package name? (E.g. mattnmoore/conductor)");
		$module['display_name']  = $this->ask("What is the module's name?");
		$module['version'] = $this->ask("What is the module's version?");
		$module['description'] = $this->ask("What is the module's description?");

		$backend = $this->ask("Will this module have a back-end component? (Y or N)");
		$module['backend'] = ($backend == 'Y' || $backend == 'y' ? true : false);

		$frontend = $this->ask("Will this module have a front-end component? (Y or N)");
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

	private function getDirectories()
	{
		return [
			'resources' => [
				'js' => [
					'controllers',
					'services',
					'filters',
					'directives'
				]
			],
			'public' => [
				'assets' => [
					'views'
				]
			]
		];
	}

	private function createDirectoriesFromArray($directories, $basePath)
	{
		foreach($directories as $key => $directory)
		{
			if(is_array($directory))
			{
                if(!$this->files->exists($basePath . $key)) $this->files->makeDirectory($basePath . $key);

                $this->createDirectoriesFromArray($directory, $basePath . $key . '/');
            }
			else
			{
                if(!$this->files->exists($basePath . $directory)) $this->files->makeDirectory($basePath . $directory);
			}
		}
	}

	private function getSkeleton($path, $data)
	{
		$skeleton = $this->files->get($path);

		$skeleton = str_replace('##module_name##', $data['name'], $skeleton);
		$skeleton = str_replace('##module_package##', $data['package_name'], $skeleton);
		$skeleton = str_replace('##module_display_name##', $data['display_name'], $skeleton);
        $skeleton = str_replace('##module_class_name##', $data['className'], $skeleton);
        $skeleton = str_replace('##module_namespace##', $data['namespace'], $skeleton);

		return $skeleton;
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
