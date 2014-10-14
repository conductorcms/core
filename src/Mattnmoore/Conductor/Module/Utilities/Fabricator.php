<?php namespace Mattnmoore\Conductor\Module\Utilities;

class Fabricator {

    public function fabricate($module)
    {
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

        //add empty scss file
        $this->files->put($basePath . '/resources/sass/main.scss', '');

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
                ],
                'sass'
            ],
            'public' => [
				'views'
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

}