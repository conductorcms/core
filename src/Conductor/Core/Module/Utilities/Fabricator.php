<?php namespace Conductor\Core\Module\Utilities;

use Illuminate\Foundation\Application;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;


class Fabricator {

    /**
     * IoC container
     *
     */
    private $app;

    /**
     * Config class
     *
     * @var Repository
     */
    private $config;

    /**
     * Filesystem class
     *
     * @var Filesystem
     */
    private $files;

    /**
     * Module basepath
     *
     * @var string
     */
    private $basePath;

    /**
     * Module info array
     *
     * @var array
     */
    private $moduleInfo;

    /**
     * Create a new Fabricator instance
     *
     * @param Repository $config
     * @param Filesystem $files
     */
    public function __construct(Application $app, Repository $config, Filesystem $files)
    {
        $this->app = $app;
        $this->config = $config;
        $this->files = $files;
    }

    /**
     * Set the module info property
     *
     * @param $moduleInfo
     */
    public function setModuleInfo($moduleInfo)
    {
        $this->moduleInfo = $moduleInfo;
        $this->basePath = $this->getModuleRoot($moduleInfo['name']);
    }

    /**
     * Fabricate the module
     *
     */
    public function fabricate()
    {
        //generate module.json
        $this->generateModuleJson($this->moduleInfo);

        //create directory structure
        $this->createDirectories();

        //generate skeleton files
        $this->generateSkeletonFiles();

        //add new module to config
        $this->addModuleToConfig();

        //load the new module
        $this->loadNewModule();
    }

    /**
     * Generate module.json from array
     *
     * @param array $module
     */
    private function generateModuleJson(array $module)
    {
        $this->files->put($this->basePath. 'module.json', json_encode($module, JSON_PRETTY_PRINT));
    }

    /**
     * Get directories and call method to generate them
     *
     */
    private function createDirectories()
    {
        $directories = $this->getDirectories();

        $this->createDirectoriesFromArray($directories, $this->basePath);
    }

    /**
     * Get directory structure
     *
     * @return array
     */
    private function getDirectories()
    {
        return [
            'resources' => [
                'admin' => [
                    'js' => [
                        'controllers',
                        'services',
                        'filters',
                        'directives'
                    ],
                    'sass',
                    'views'
                ],
                'frontend' => [
                ]
            ],
        ];
    }

    /**
     * Recursively create directory structure from array
     *
     * @param array $directories
     * @param $basePath
     */
    private function createDirectoriesFromArray(array $directories, $basePath)
    {
        foreach ($directories as $key => $directory)
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

    /**
     * Call methods to include module in the config
     * file and the config loaded into memory
     *
     */
    private function addModuleToConfig()
    {
        $this->addModuleToConfigFile();
        $this->addModuleToLoadedConfig();
    }

    /**
     * Include new module files and register
     * the module provider and underlying
     * service provider
     */
    private function loadNewModule()
    {
        $moduleRoot = $this->basePath;
        $data = $this->getModuleInfo();

        $path = $moduleRoot . '/src/' .  $data['packageName'] . '/';

        require $path . $data['className'] .  'ModuleProvider.php';
        require $path . $data['className'] .  '.php';

        $provider = $data['namespace'] . '\\' . $data['className'] . 'ModuleProvider';
        $provider = new $provider($this->app->make('app'));
        $provider->registerModule();
    }

    /**
     * Add module provider to the
     * module config array
     */
    private function addModuleToConfigFile()
    {
		$reflection = new ReflectionClass($this);
		$path = dirname($reflection->getFileName);
		dd($path);

        //open file
        $file = base_path() . '/workbench/mattnmoore/conductor/src/config/modules.php';
        $fh = fopen($file, 'r+');

        $data = $this->getModuleInfo();
        $provider = $data['namespace'] . '\\' . $data['className'] . 'ModuleProvider';

        //get provider name
        $provider = "    '" . $provider . "'," . PHP_EOL . "];";

        //add to config
        fseek($fh, -2, SEEK_END);
        fwrite($fh, $provider);

        fclose($fh);
    }

    /**
     * Add module provider to the
     * config loaded in memory
     */
    private function addModuleToLoadedConfig()
    {
        $data = $this->getModuleInfo();
        $provider = $data['namespace'] . '\\' . $data['className'] . 'ModuleProvider';

        $config = $this->config->get('conductor::modules');
        $config[] = $provider;
        $this->config->set('conductor::modules', $config);
    }

    /**
     * Generate skeleton files for module
     */
    private function generateSkeletonFiles()
    {
        $data = $this->getModuleInfo();

        $providerPath = $this->getProviderPath($data);

        $this->files->delete($providerPath . 'ServiceProvider.php');

        $files = [
            'resources/admin/js/' . $data['name'] . '.js'                      => $this->getSkeletonPath('app.skeleton.js'),
            'resources/admin/js/controllers/' . $data['className'] . 'Ctrl.js' => $this->getSkeletonPath('controller.skeleton.js'),
            $providerPath . 'ModuleProvider.php'                         => $this->getSkeletonPath('provider.skeleton'),
            $providerPath . '.php'                                       => $this->getSkeletonPath('module.skeleton')
        ];

        $this->generateSkeletonsFromArray($files, $data);

        //add empty routes file
        $this->files->put($this->basePath . '/src/routes.php', '');

        //add empty scss file
        $this->files->put($this->basePath . '/resources/admin/sass/main.scss', '');

        //add view skeleton
        $this->files->copy($this->getSkeletonPath('view.skeleton.html'), $this->basePath . 'resources/admin/views/index.html');
    }

    /**
     * Get the path to a skeleton
     * file from the name
     *
     * @param $name
     * @return string
     */
    private function getSkeletonPath($name)
    {
        return base_path() . '/workbench/mattnmoore/conductor/resources/skeletons/' . $name;
    }

    /**
     * Get the module provider filepath
     *
     * @param $data
     * @return mixed
     */
    private function getProviderPath($data)
    {
        $path = $this->getModuleRoot($data['packageName']) . 'src/' . $data['namespace'] . '/' . $data['className'];

        return str_replace('\\', '/', $path);
    }

    /**
     * Generate skeleton files from array
     *
     * @param array $files
     * @param $data
     */
    private function generateSkeletonsFromArray(array $files, $data)
    {
        foreach($files as $path => $skeleton)
        {
            $skeleton = $this->getSkeleton($skeleton, $data);
            $this->files->put($path, $skeleton);
        }
    }

    /**
     * Get a skeleton file with replaced tags
     *
     * @param $path
     * @param $data
     * @return mixed
     */
    private function getSkeleton($path, $data)
    {
        $skeleton = $this->files->get($path);

        $tags = $this->getSkeletonTags($data);

        return $this->replaceTags($tags, $skeleton);
    }

    /**
     * Get tags to replace in skeleton files
     * and values to replace them with
     *
     * @param $data
     * @return array
     */
    private function getSkeletonTags($data)
    {
        return [
            '##module_name##'         => $data['name'],
            '##module_package##'      => $data['packageName'],
            '##module_display_name##' => $data['displayName'],
            '##module_class_name##'   => $data['className'],
            '##module_namespace##'    => $data['namespace']
        ];
    }

    /**
     * Find and replace for skeleton files
     *
     * @param array $tags
     * @param $skeleton
     * @return mixed
     */
    private function replaceTags(array $tags, $skeleton)
    {
        foreach($tags as $tag => $replacement)
        {
            $skeleton = str_replace($tag, $replacement, $skeleton);
        }

        return $skeleton;
    }

    /**
     * Get the module's root path
     *
     * @param $packageName
     * @return string
     */
    private function getModuleRoot($packageName)
    {
        return base_path() . '/workbench/' . $packageName . '/';
    }

    /**
     * Get module info array
     *
     * @return array
     */
    private function getModuleInfo()
    {
        $parts = explode('/', $this->moduleInfo['name']);

        return [
            'name' => $parts[1],
            'packageName' => $this->moduleInfo['name'],
            'displayName' => $this->moduleInfo['display_name'],
            'namespace' => ucfirst($parts[0]) . '\\' . ucfirst($parts[1]),
            'className' => ucfirst($parts[1])
        ];
    }
}