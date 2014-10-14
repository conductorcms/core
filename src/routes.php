<?php

Route::get('admin/login', 'Mattnmoore\Http\Controllers\AdminController@login');

Route::get('admin', ['middleware' => 'admin', 'uses' => 'Mattnmoore\Http\Controllers\AdminController@index']);
Route::get('admin/{slug}', ['middleware' => 'admin', 'uses' => 'Mattnmoore\Http\Controllers\AdminController@index']);

Route::get('admin/api/v1/modules', 'Mattnmoore\Http\Controllers\ApiController@modules');
Route::get('admin/api/v1/module/{id}/install', 'Mattnmoore\Http\Controllers\ApiController@installModule');
Route::get('admin/api/v1/module/{id}/uninstall', 'Mattnmoore\Http\Controllers\ApiController@uninstallModule');

Route::get('/admin/api/v1/session', 'Mattnmoore\Http\Controllers\SessionController@get');
Route::post('/admin/api/v1/session', 'Mattnmoore\Http\Controllers\SessionController@create');
Route::get('/admin/api/v1/session/destroy', 'Mattnmoore\Http\Controllers\SessionController@destroy');

