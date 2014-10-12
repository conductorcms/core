<?php namespace Mattnmoore\Conductor\Module;

use Illuminate\Database\Eloquent\Model;

class ModuleModel extends Model {

	public $table = 'modules';

	public $fillable = ['name', 'display_name', 'description', 'version', 'frontend', 'backend'];

    public function authors()
    {
        return $this->hasMany('Mattnmoore\Conductor\Module\ModuleAuthor', 'module_id');
    }

}