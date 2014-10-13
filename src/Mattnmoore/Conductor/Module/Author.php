<?php namespace Mattnmoore\Conductor\Module;

use Illuminate\Database\Eloquent\Model;

class Author extends Model {

	public $table = 'module_authors';

    public $fillable = ['name', 'email', 'module_id'];

    public $timestamps = false;

}