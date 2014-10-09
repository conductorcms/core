<?php

Route::get('admin', 'Mattnmoore\Conductor\Controllers\AdminController@index');

Route::get('admin/modules', 'Mattnmoore\Conductor\Controllers\AdminController@modules');

Route::get('admin/{slug}', 'Mattnmoore\Conductor\Controllers\AdminController@moduleAdmin');