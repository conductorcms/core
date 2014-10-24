<?php namespace Conductor\Core\Http\Filters;

use Illuminate\Contracts\Routing\ResponseFactory;
use Cartalyst\Sentinel\Sentinel;

class Permissions {

    private $response;

    private $sentinel;

    function __construct(ResponseFactory $response, Sentinel $sentinel)
    {
        $this->response = $response;
        $this->sentinel = $sentinel;
    }

	public function filter($route, $request, $permissions, $options = [])
	{
        if(!$user = $this->sentinel->check())
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