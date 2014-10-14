<?php namespace Mattnmoore\Conductor\Module;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Author extends Eloquent {

    public $table = 'module_authors';

    public $fillable = ['name', 'email', 'module_id'];

    public $timestamps = false;

}