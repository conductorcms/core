<?php namespace Conductor\Core\Module;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Author extends Eloquent {

    public $table = 'core_module_authors';

    public $fillable = ['name', 'email', 'module_id'];

    public $timestamps = false;

}