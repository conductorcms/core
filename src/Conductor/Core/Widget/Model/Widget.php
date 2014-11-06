<?php namespace Conductor\Core\Widget\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Widget extends Eloquent {

	public $fillable = ['name', 'description', 'slug'];

    public function instances()
    {
        return $this->hasMany('Conductor\Core\Widget\Model\Instance', 'widget_id', 'id');
    }

}