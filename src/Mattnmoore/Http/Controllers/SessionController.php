<?php namespace Mattnmoore\Http\Controllers;

use Sentinel;
use View;
use Response;
use Input;

class SessionController {

	public function get()
	{
		if($user = Sentinel::check()) return Response::json(['session' => true, 'user' => $user], 200);

		return Response::json(['session' => false], 200);
	}

	public function create()
	{
		$credentials = [
			'email' => Input::get('email'),
			'password' => Input::get('password')
		];

		if($user = Sentinel::authenticate($credentials)) return Response::json(['session' => true, 'user' => $user]);

		return Response::json(['session' => false, 'message' => 'Unable to authenticate user']);
	}

	public function destroy()
	{
		if($user = Sentinel::check()) Sentinel::logout();

		return Response::json(['session' => false], 200);
	}

}