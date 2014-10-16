<?php

Route::group(['namespace' => 'Mattnmoore\\Conductor\\Http\\Controllers'], function ()
{
    Route::get('admin/login', 'AdminController@login');

    //Admin panel routes
    Route::group(['middleware' => 'admin'], function ()
    {
        Route::get('admin', 'AdminController@index');
        Route::get('admin/{slug{', 'AdminController@index');
    });

    //Admin panel API endpoints
    Route::group(['prefix' => 'admin/api/v1/'], function ()
    {
        Route::get('modules', 'ApiController@modules');
        Route::get('module/{id}/install', 'ApiController@installModule');
        Route::get('module/{id}/uninstall', 'ApiController@uninstallModule');

        Route::get('session', 'SessionController@get');
        Route::post('session', 'SessionController@create');
        Route::get('session/destroy', 'SessionController@destroy');
    });


});

Route::get('theme', function()
{
    $data['theme'] = Config::get('conductor::themes.active');
    $data['layout'] = $data['theme'] . '.layouts.master';
    $data['title'] = 'Title Test';

    return View::make($data['theme']. '.index', $data);
});