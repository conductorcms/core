<?php namespace Conductor\Core\Widget;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Area extends Eloquent {

	public $table = 'widget_areas';

    public $fillable = ['name', 'slug'];

    public function widgetInstances()
    {
        return $this->belongsToMany('Conductor\Core\Widget\Instance', 'widget_area_instances', 'area_id', 'instance_id');
    }
}