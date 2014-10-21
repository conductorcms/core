<?php namespace Conductor\Core;

use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser {

	public $hidden = ['password', 'updated_at', 'created_at'];

}