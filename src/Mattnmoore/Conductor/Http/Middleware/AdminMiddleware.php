<?php namespace Mattnmoore\Conductor\Http\Middleware;

use Sentinel;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Contracts\Routing\ResponseFactory;

class AdminMiddleware implements Middleware {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * The response factory implementation.
	 *
	 * @var ResponseFactory
	 */
	protected $response;

	/**
	 * Create a new filter instance.
	 *
	 * @param  ResponseFactory $response
	 */
	public function __construct(ResponseFactory $response)
	{
		$this->response = $response;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(Sentinel::guest())
		{
			if($request->ajax())
			{
				return $this->response->make('Unauthorized', 401);
			}

			return $this->response->redirectGuest('/admin/login');
		}

		if(!Sentinel::inRole('administrators')) return $this->response->redirectGuest('/admin/login');

		return $next($request);
	}

}
