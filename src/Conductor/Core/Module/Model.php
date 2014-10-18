<?php namespace Conductor\Core\Module;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent {

    public $table = 'core_modules';

    public $fillable = ['name', 'display_name', 'description', 'version', 'frontend', 'backend'];

    public function authors()
    {
        return $this->hasMany('Conductor\Core\Module\Author', 'module_id');
    }

}