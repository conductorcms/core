<?php namespace Conductor\Core;

class UserHandler {

    protected $user;

    function __construct(User $user)
    {
        $this->user = $user;

        $this->register();
    }

    public function register()
    {
        $this->user->registerHandler($this);
    }

}