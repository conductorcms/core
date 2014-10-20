<?php namespace Conductor\Core\Http\Filters;

class Permissions {

	public function filter($route, $request, $permissions)
	{
		$permissions = explode(';', $permissions);
		dd($permissions);
	}

}