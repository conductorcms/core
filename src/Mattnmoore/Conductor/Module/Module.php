<?php namespace Mattnmoore\Conductor\Module;

use Illuminate\Database\Eloquent\Model;

class Module extends Model {

	public $fillable = ['name', 'display_name', 'description', 'version', 'author'];

}