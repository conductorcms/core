<?php namespace Conductor\Core\Widget;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Area extends Eloquent {

	public $table = 'widget_areas';

    public $fillable = ['name', 'slug'];

    public function widgetInstances()
    {
        return $this->hasMany('Conductor\Core\Widget\Instance');
    }
}