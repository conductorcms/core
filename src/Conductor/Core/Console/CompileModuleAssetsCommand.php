<?php namespace Conductor\Core\Console;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application as App;
use Illuminate\Console\Application;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use ReflectionClass;
use Conductor\Core\Module\ModuleRepository;

class CompileModuleAssetsCommand extends Command {

    protected $app;

    protected $config;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:compile-assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compile enabled module assets.';

    /**
     * Create a new Console Instance
     *
     * @param ModuleRepository $module
     */
    public function __construct(App $app, ModuleRepository $module, Repository $config)
    {
        $this->app = $app;

        $this->module = $module;

        $this->config = $config;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $modules = $this->module->getAll();

        $this->info('Modules found: ' . $modules->count());

        $basePath = $this->option('basePath');

        $assetManifest = ['backend' => [], 'frontend' => []];

        foreach ($modules as $module)
        {
            $this->info($module->name);

            $reflection = new ReflectionClass($this->app->make($module->name));

            $path = $reflection->getFileName();

            $assets = substr($path, 0, strpos($path, $module->name . '/'));

            $moduleRoot = $assets . $module->name . '/';

            $this->info($moduleRoot);

            $assets = $moduleRoot . 'module.json';

            $this->info($assets);

            $json = json_decode(file_get_contents($assets));

            $base = $moduleRoot;
            if(isset($basePath)) $base = $basePath . $module->name . '/';

            $backendAssets = $this->getAssets('backend', $json, $base, $module->name);

            $frontendAssets = $this->getAssets('frontend', $json, $base, $module->name);

            $assetManifest['backend'] = array_merge_recursive($backendAssets, $assetManifest['backend']);

            $assetManifest['frontend'] = array_merge_recursive($frontendAssets, $assetManifest['frontend']);
		}

		$themeAssets = $this->getThemeAssets();

        $themeDependencies = $this->getThemeDependencies();

        $assetManifest['frontend']['dependencies'] = array_merge_recursive($themeDependencies, $assetManifest['frontend']['dependencies']);

		$assetManifest['frontend'] = array_merge_recursive($themeAssets, $assetManifest['frontend']);

        $assetManifest = array_merge_recursive($this->getCoreAssets(), $assetManifest);

        file_put_contents(__DIR__ . '../../../../../asset_manifest.json', json_encode($assetManifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    private function getAssets($type, $json, $base, $moduleName)
    {
        $assetManifest = [];

        $module = explode('/', $moduleName);
        $module = $module[1];

        $assetManifest['js'] = $this->getAssetType($type, 'js', $base, $json);
        $assetManifest['sass'] = $this->getAssetType($type, 'sass', $base, $json);
        $assetManifest['views'] = $this->getAssetType($type, 'views', $base, $json, $module);
		$assetManifest['dependencies'] = $this->getDependencies($type, $json);

        return $assetManifest;
    }

    private function getThemeAssets()
    {
		$active = $this->getActiveTheme();

        array_walk_recursive($active, function (&$value, $key) use ($active)
        {
            $value = $active['path'] . $value;
        });

        return $active['assets'];
    }


	private function getThemeDependencies()
	{
		$dependencies = [];
		$active = $this->getActiveTheme();

		$source = '';

        if(!isset($active['dependencies']['files'])) return [];

		foreach($active['dependencies']['files'] as $key => $group)
		{
			if($key == 'source')
			{
				$source = $group;
			}
			else
			{
				$dependencies[$key] = [];
				foreach($group as $asset)
				{
					$dependencies[$key][] = $source . '/' . $asset;
				}
			}
		}

		return $dependencies;
	}

	private function getActiveTheme()
	{
		$theme = $this->app->make('Conductor\Core\Theme\Theme');

		$themes = $theme->getThemes($this->config->get('core::conductor.themes.dir'));

		$activeTheme = $this->config->get('core::conductor.themes.active');

		return $themes[$activeTheme];
	}


	private function getDependencies($group, $json)
	{
		$dependencies = [];
		$source = '';

		if(!isset($json->dependencies->files->{$group})) return [];

		// filter through css / js types
		foreach($json->dependencies->files->{$group} as $key => $type)
		{
			if($key == 'source')
			{
				$source = $type;
			}
			else
			{
				$dependencies[$key] = [];

				// filter through each asset and prefix if source is set
				foreach($type as $asset)
				{
					$dependencies[$key][] = $source . '/' . $asset;
				}

			}

		}

		return $dependencies;
	}

    private function getAssetType($assetGroup, $type, $base, $json, $module = '')
    {
        $assets = [];

        if(!isset($json->assets->{$assetGroup}->{$type})) return [];

        foreach ($json->assets->{$assetGroup}->{$type} as $asset)
        {
            if($module != '')
            {
                $assets[$module][] = $base . $asset;
            }
            else
            {
                $assets[] = $base . $asset;
            }
        }

        return $assets;
    }

    private function getCoreAssets()
    {
        $json = file_get_contents(__DIR__ . '/../../../../core.json');

        $core = json_decode($json, true);

        $dependencies = [];

        $source = '';
        if(isset($core['dependencies']['files']['backend']['source'])) $source = $core['dependencies']['files']['backend']['source'];

        foreach($core['dependencies']['files']['backend'] as $key => $group)
        {
            if($key == 'source')
            {
                $source = $group;
            }
            else
            {
                $dependencies[$key] = [];
                foreach($group as $file)
                {
                    $dependencies[$key][] = __DIR__ . '/../../../../../../../' . $source . '/' . $file;
                }

            }

        }

        $manifest['backend'] = $core['assets']['backend'];
        $manifest['backend']['dependencies'] = $dependencies;

        return $manifest;
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
            ['basePath', 'base', InputOption::VALUE_OPTIONAL, 'Register a base path manually (useful for setting host paths instead of VMs', null]
        ];
    }

}
