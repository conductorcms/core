<?php

//Route::get('admin', 'Mattnmoore\Conductor\Controllers\AdminController@index');

Route::get('admin/login', 'Mattnmoore\Conductor\Controllers\AdminController@login');

Route::get('admin', ['middleware' => 'admin', 'uses' => 'Mattnmoore\Conductor\Controllers\AdminController@index']);
Route::get('admin/{slug}', ['middleware' => 'admin', 'uses' => 'Mattnmoore\Conductor\Controllers\AdminController@index']);

Route::get('admin/api/v1/modules', 'Mattnmoore\Conductor\Controllers\ApiController@modules');
Route::get('admin/api/v1/module/{id}/install', 'Mattnmoore\Conductor\Controllers\ApiController@installModule');
Route::get('admin/api/v1/module/{id}/uninstall', 'Mattnmoore\Conductor\Controllers\ApiController@uninstallModule');

Route::get('/admin/api/v1/session', 'Mattnmoore\Conductor\Controllers\SessionController@get');
Route::post('/admin/api/v1/session', 'Mattnmoore\Conductor\Controllers\SessionController@create');
Route::get('/admin/api/v1/session/destroy', 'Mattnmoore\Conductor\Controllers\SessionController@destroy');