<?php namespace Mattnmoore\Conductor\Console;

use Illuminate\Foundation\Application as App;
use Illuminate\Console\Application;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use ReflectionClass;
use Mattnmoore\Conductor\Module\ModuleRepository;

class CompileModuleAssetsCommand extends Command {

    protected $app;

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
    public function __construct(App $app, ModuleRepository $module)
    {
        $this->app = $app;

        $this->module = $module;

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

        $assetManifest = [];

        foreach ($modules as $module)
        {
            $this->info($module->name);

            $reflection = new ReflectionClass($this->app->make($module->name));

            $path = $reflection->getFileName();

            $assets = substr($path, 0, strpos($path, $module->name . '/'));

            $moduleRoot = $assets . $module->name . '/';

            $assets = $moduleRoot . 'module.json';

            $this->info($assets);

            $json = json_decode(file_get_contents($assets));

            foreach ($json->assets->js as $asset)
            {
                $assetManifest['js'][] = $moduleRoot . $asset;
            }

            foreach ($json->assets->sass as $asset)
            {
                $assetManifest['sass'][] = $moduleRoot . $asset;
            }
        }

        file_put_contents(__DIR__ . '../../../asset_manifest.json', json_encode($assetManifest, JSON_PRETTY_PRINT));
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
