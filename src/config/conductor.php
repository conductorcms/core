<?php

return [

    'site_name' => 'Conductor',

    'google_analytics' => '',

    /*
    /--------------------------------------------------------------------------
    / Metatag defaults
    /--------------------------------------------------------------------------
    /
    / These will probably be overwritten by
    / a setting, but you can set fallbacks
    / here
    */
    'metatags' => [
        'description' => 'Meta descriptions!',
        'keywords' => 'very, fun, wow, such, keywords'
    ],


    /*
    /--------------------------------------------------------------------------
    / Theme configuration
    /--------------------------------------------------------------------------
    /
    / Here you may specify which theme is active by default. You may override
    / this in the settings from the admin panel. You can also specify
    / where the base directory for themes is located.
    */
    'themes' => [
        'active' => 'default',
        'dir' => 'resources/themes',
    ],

    /*
    /--------------------------------------------------------------------------
    / Module provider manifest
    /--------------------------------------------------------------------------
    /
    / Here you can manage which modules registered
    / are by adding module providers
    */
    'modules' => [

    ],

    /*
    /--------------------------------------------------------------------------
    / Widgetmanifest
    /--------------------------------------------------------------------------
    /
    / Here you can manage which widgets registered
    / are by adding widget paths
    */
    'widgets' => [
        'Conductor\Core\Widgets\Html\Html'
    ],

];