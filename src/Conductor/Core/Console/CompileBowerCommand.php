<?php namespace Conductor\Core\Console;

use Illuminate\Console\Application;
use Illuminate\Foundation\Application as App;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Conductor\Core\Module\ModuleRepository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository;

class CompileBowerCommand extends Command {

    protected $module;

    protected $files;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:compile-bower';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compile bower dependencies into main bower.json';

    /**
     * Create a new Console Instance
     *
     * @param ModuleRepository $module
     */
    public function __construct(App $app, ModuleRepository $module, Filesystem $files, Repository $config)
    {
        $this->app = $app;

        $this->module = $module;

        $this->files = $files;

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

        // get bower if exists, otherwise skeleton array
        $bower = $this->getBower();

        // get core bower
        $coreBower = $this->getCoreDependencies();

        // get modules bower
        $moduleBower = [];

        foreach($modules as $module)
        {
            $dependencies = $this->getModuleDependencies($module);

            $moduleBower = array_merge_recursive($moduleBower, $dependencies);
        }

        // get theme bower
        $themeBower = [];
        $theme = $this->getActiveTheme();

        if(isset($theme['dependencies']['bower'])) $themeBower = $theme['dependencies']['bower'];

        // combine
        $bower['dependencies'] = array_merge_recursive($coreBower, $moduleBower);

        $bower['dependencies'] = array_merge($bower['dependencies'], $themeBower);

        // output
        file_put_contents(base_path() . '/bower.json', json_encode($bower, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    private function getActiveTheme()
    {
        $theme = $this->app->make('Conductor\Core\Theme\Theme');

        $themes = $theme->getThemes($this->config->get('core::conductor.themes.dir'));

        $activeTheme = $this->config->get('core::conductor.themes.active');

        return $themes[$activeTheme];
    }

    private function getModuleDependencies($module)
    {
        $reflection = new \ReflectionClass($this->app->make($module->name));

        $path = $reflection->getFileName();

        $assets = substr($path, 0, strpos($path, $module->name . '/'));

        $moduleRoot = $assets . $module->name . '/';

        $assets = $moduleRoot . 'module.json';

        $json = json_decode(file_get_contents($assets), true);

        if(isset($json['dependencies']['bower'])) return $json['dependencies']['bower'];

        return [];
    }

    private function getBower()
    {
        $bowerPath = base_path() . '/bower.json';

        if(!$this->files->exists($bowerPath))
        {
            return ['name' => '', 'version' => '', 'dependencies' => []];
        }

        $bower = file_get_contents($bowerPath);
        $bower = json_decode($bower, true);

        return $bower;
    }

    private function getCoreDependencies()
    {
        $json = file_get_contents(__DIR__ . '/../../../../core.json');
        $core = json_decode($json, true);

        return $core['dependencies']['bower'];
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
