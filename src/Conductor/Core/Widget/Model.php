<?php namespace Conductor\Core\Widget;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent {

	public $table = 'widgets';

	public $fillable = ['name', 'description', 'slug'];

    public function instances()
    {
        return $this->hasMany('Conductor\Core\Widget\Instance', 'widget_id', 'id');
    }

}