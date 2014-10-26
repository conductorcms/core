<?php

Route::filter('permissions', 'Conductor\Core\Http\Filters\Permissions');

Route::group(['namespace' => 'Conductor\\Core\\Http\\Controllers'], function()
{
    Route::get('login', 'AdminController@login');

    Route::get('session', 'SessionController@get');
    Route::post('session', 'SessionController@create');
    Route::get('session/destroy', 'SessionController@destroy');

    //Admin panel API endpoints
    Route::group(['prefix' => 'admin/api/v1/', 'before' => setPermissions(['admin'])], function()
    {

        Route::get('modules', 'ApiController@modules');
        Route::get('module/{id}/install', 'ApiController@installModule');
        Route::get('module/{id}/uninstall', 'ApiController@uninstallModule');
        Route::get('routes', 'ApiController@routes');
		Route::get('widgets', 'WidgetController@all');
		Route::get('widget/areas', 'WidgetController@areas');

	});

    //Admin panel routes
	Route::group(['before' => setPermissions(['admin'])], function()
	{
		Route::get('admin', 'AdminController@index');
		Route::get('admin/{slug}', 'AdminController@index');
		Route::get('admin/{slug}/{slugTwo}', 'AdminController@index');
		Route::get('admin/{slug}/{slugTwo}/{slugThree}', 'AdminController@index');
		Route::get('admin/{slug}/{slugTwo}/{slugThree/slugFour}', 'AdminController@index');
	});
	
});



Route::get('theme', function()
{
    $data['theme'] = Config::get('conductor::themes.active');
    $data['layout'] = $data['theme'] . '.layouts.master';
    $data['title'] = 'Title Test';

    return View::make($data['theme']. '.index', $data);
});