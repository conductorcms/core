<?php namespace Conductor\Core\Http\Filters;

use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Cartalyst\Sentinel\Sentinel;

class Permissions {

    private $auth;

	private $redirect;

	private $response;

    function __construct(Sentinel $auth, Redirector $redirect, Response $response)
    {
        $this->auth = $auth;
		$this->redirect = $redirect;
		$this->response = $response;
    }

	public function filter($route, $request, $permissions, $options = [])
	{
        if(!$user = $this->auth->check())
        {
            if($request->ajax()) return $this->response->make('Unauthorized', 401);
            return $this->redirect->to('/login');
        }

        $permissions = explode(';', $permissions);

        if(!$user->hasAccess($permissions))
        {
            if($request->ajax()) return $this->response->make('Unauthorized', 401);
            return $this->redirect->to('/');
        }
	}

}