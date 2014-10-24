<?php namespace Conductor\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use View, Response, Input;
use Cartalyst\Sentinel\Sentinel;

class SessionController extends Controller {

    private $sentinel;

    function __construct(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
    }

    public function get()
    {
        if($user = $this->sentinel->check())
        {
            $user->getRoles();
            $user->permissions = $user->roles[0]->permissions;
            return Response::json(['session' => true, 'user' => $user], 200);
        }

        return Response::json(['session' => false], 200);
    }

    public function create()
    {
        $credentials = [
            'email' => Input::get('email'),
            'password' => Input::get('password')
        ];

        if($user = $this->sentinel->authenticate($credentials)) return Response::json(['session' => true, 'user' => $user]);

        return Response::json(['session' => false, 'message' => 'Unable to authenticate user']);
    }

    public function destroy()
    {
        if($user = $this->sentinel->check()) $this->sentinel->logout();

        return Response::json(['session' => false], 200);
    }

}