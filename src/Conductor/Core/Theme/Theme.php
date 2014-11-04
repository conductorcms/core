<?php namespace Conductor\Core\Theme;

use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;

class Theme {

    private $config;

    private $files;

    function __construct(Repository $config, Filesystem $files)
    {
        $this->config = $config;
        $this->files = $files;
    }

    public function getThemes($base)
    {
        $jsonArray = $this->files->glob(base_path() . '/' . $base . '/**/theme.json');

        $themes = [];

        foreach($jsonArray as $json)
        {
            $path = str_replace('theme.json', '', $json);
            $theme = $this->getThemeJson($json);

            if(!is_null($theme))
            {
                $theme['path'] = $path;

                $themes[strtolower($theme['name'])] = $theme;
            }

        }

        return $themes;
    }

    public function getThemeJson($path)
    {
        return json_decode(file_get_contents($path), true);
    }

}