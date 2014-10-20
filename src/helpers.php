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


