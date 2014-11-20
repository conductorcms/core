<?php

Route::filter('permissions', 'Conductor\Core\Http\Filters\Permissions');

Route::group(['namespace' => 'Conductor\\Core\\Http\\Controllers'], function ()
{
    Route::get('login', 'AdminController@login');

    Route::get('session', 'SessionController@get');
    Route::post('session', 'SessionController@create');
    Route::get('session/destroy', 'SessionController@destroy');

    //Admin panel API endpoints
    Route::group(['prefix' => 'admin/api/v1/', 'before' => setPermissions(['admin'])], function ()
    {
        Route::get('settings', 'SettingController@getAll');
        Route::post('settings/batch', 'SettingController@storeBatch');

        Route::get('modules', 'ApiController@modules');
        Route::get('module/{id}/install', 'ApiController@installModule');
        Route::get('module/{id}/uninstall', 'ApiController@uninstallModule');

        Route::get('routes', 'ApiController@routes');

        Route::get('widgets', 'WidgetController@all');
        Route::get('widget/{id}/options', 'WidgetController@getOptions');

        Route::post('widget/areas', 'WidgetAreaController@store');
        Route::put('widget/area/{id}/instances', 'WidgetAreaController@syncInstances');
        Route::get('widget/areas', 'WidgetAreaController@all');
        Route::delete('widget/area/{id}', 'WidgetAreaController@destroy');

        Route::get('widget/instances', 'WidgetInstanceController@all');
        Route::post('widget/{id}/instance', 'WidgetInstanceController@store');

        Route::get('widget/instance/{id}', 'WidgetInstanceController@get');
        Route::delete('widget/instance/{id}', 'WidgetInstanceController@destroy');
    });

    //Admin panel routes
    Route::group(['before' => setPermissions(['admin'])], function ()
    {
        Route::get('admin', 'AdminController@index');
        Route::get('admin/{slug}', 'AdminController@index');
        Route::get('admin/{slug}/{slugTwo}', 'AdminController@index');
        Route::get('admin/{slug}/{slugTwo}/{slugThree}', 'AdminController@index');
        Route::get('admin/{slug}/{slugTwo}/{slugThree/slugFour}', 'AdminController@index');
    });

});

// catch-all for pages module
Route::get('{slug}', 'Conductor\Pages\Http\Controllers\PageController@buildPage');
Route::get('/', 'Conductor\Pages\Http\Controllers\PageController@buildHome');


