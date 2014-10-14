<?php

Route::group(['namespace' => 'Mattnmoore\\Conductor\\Http\\Controllers'], function()
{
	Route::get('admin/login', 'AdminController@login');

	Route::get('admin', ['middleware' => 'admin', 'uses' => 'AdminController@index']);
	Route::get('admin/{slug}', ['middleware' => 'admin', 'uses' => 'AdminController@index']);

	Route::get('admin/api/v1/modules', 'ApiController@modules');
	Route::get('admin/api/v1/module/{id}/install', 'ApiController@installModule');
	Route::get('admin/api/v1/module/{id}/uninstall', 'ApiController@uninstallModule');

	Route::get('/admin/api/v1/session', 'SessionController@get');
	Route::post('/admin/api/v1/session', 'SessionController@create');
	Route::get('/admin/api/v1/session/destroy', 'SessionController@destroy');

});