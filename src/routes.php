<?php

Route::get('admin', 'Mattnmoore\Conductor\Controllers\AdminController@index');

Route::get('admin/modules', 'Mattnmoore\Conductor\Controllers\AdminController@index');

Route::get('admin/{slug}', 'Mattnmoore\Conductor\Controllers\AdminController@moduleAdmin');

Route::get('admin/api/v1/modules', 'Mattnmoore\Conductor\Controllers\ApiController@modules');
Route::get('admin/api/v1/module/{id}/install', 'Mattnmoore\Conductor\Controllers\ApiController@installModule');
Route::get('admin/api/v1/module/{id}/uninstall', 'Mattnmoore\Conductor\Controllers\ApiController@uninstallModule');



use Mattnmoore\Conductor\Module\ModuleInfo;
use Mattnmoore\Battletracker\Battletracker;

Route::get('angular', function()
{
	$angularSkeleton = File::get(base_path() . '/workbench/mattnmoore/conductor/src/console/resources/angular_skeleton.js');

	$angularSkeleton = str_replace('##module_name##', 'battletracker', $angularSkeleton);
	$angularSkeleton = str_replace('##module_package##', 'mattnmoore/battletracker', $angularSkeleton);
	$angularSkeleton = str_replace('##module_display_name##', 'Battletracker', $angularSkeleton);

	dd($angularSkeleton);
});