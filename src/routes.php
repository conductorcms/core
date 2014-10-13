<?php

Route::get('admin', 'Mattnmoore\Conductor\Controllers\AdminController@index');

Route::get('admin/modules', 'Mattnmoore\Conductor\Controllers\AdminController@index');

Route::get('admin/{slug}', 'Mattnmoore\Conductor\Controllers\AdminController@moduleAdmin');

Route::get('admin/api/v1/modules', 'Mattnmoore\Conductor\Controllers\ApiController@modules');
Route::get('admin/api/v1/module/{id}/install', 'Mattnmoore\Conductor\Controllers\ApiController@installModule');
Route::get('admin/api/v1/module/{id}/uninstall', 'Mattnmoore\Conductor\Controllers\ApiController@uninstallModule');