<?php namespace Conductor\Core\Http\Filters;

use Illuminate\Contracts\Routing\ResponseFactory;
use Sentinel;

class Permissions {

    private $auth;

    private $response;

    function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

	public function filter($route, $request, $permissions, $options = [])
	{
        if(!$user = Sentinel::check())
        {
            if($request->ajax()) return $this->response->make('Unauthorized', 401);
            return $this->response->redirectGuest('/login');
        }

        $permissions = explode(';', $permissions);

        if(!$user->hasAccess($permissions))
        {
            if($request->ajax()) return $this->response->make('Unauthorized', 401);
            return $this->response->redirectTo('/');
        }
	}

}