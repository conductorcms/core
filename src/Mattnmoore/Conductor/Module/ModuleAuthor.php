<?php namespace Mattnmoore\Conductor\Module;

use Illuminate\Database\Eloquent\Model;

class ModuleAuthor extends Model {

    public $fillable = ['name', 'email', 'module_id'];

    public $timestamps = false;

}