<?php namespace Conductor\Core;

use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser {

    /**
     * @var array
     */
    public static $handlers = [];

    /**
     * @var array
     */
    public $hidden = ['password', 'updated_at', 'created_at'];

    /**
     * @param $handler
     */
    public function registerHandler($handler)
    {
        static::$handlers[] = $handler;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if(!is_callable('parent::' . $method))
        {
            foreach (static::$handlers as $handler)
            {
                return call_user_func_array([$handler, $method], $arguments);
            }
        }

        return parent::__call($method, $arguments);
    }

}