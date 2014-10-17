<?php namespace Conductor\Core\Module;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent {

    public $table = 'modules';

    public $fillable = ['name', 'display_name', 'description', 'version', 'frontend', 'backend'];

    public function authors()
    {
        return $this->hasMany('Mattnmoore\Conductor\Module\Author', 'module_id');
    }

}