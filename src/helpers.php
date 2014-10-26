<?php

//prepare filter for permissions
function setPermissions(array $permissions)
{
	$filter = 'permissions:';
	foreach($permissions as $permission)
	{
		$filter = $filter . $permission . ';';
	}
    $filter = rtrim($filter, ';');
	return $filter;
}

function loadWidgetInstance($slug)
{
	$widget = App::make('conductor:widget:' . $slug);

	return $widget->buildInstanceView($slug);
}

function loadWidgetArea($slug)
{
	$widget = App::make('Conductor\Core\Widget\Widget');

	return $widget->buildAreaView($slug);
}




