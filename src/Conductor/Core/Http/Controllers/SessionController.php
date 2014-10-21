<?php namespace Conductor\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Sentinel, View, Response, Input;

class SessionController extends Controller {

    public function get()
    {
        if($user = Sentinel::check())
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

        if($user = Sentinel::authenticate($credentials)) return Response::json(['session' => true, 'user' => $user]);

        return Response::json(['session' => false, 'message' => 'Unable to authenticate user']);
    }

    public function destroy()
    {
        if($user = Sentinel::check()) Sentinel::logout();

        return Response::json(['session' => false], 200);
    }

}