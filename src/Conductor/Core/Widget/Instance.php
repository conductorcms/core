<?php namespace Conductor\Core\Widget;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Instance extends Eloquent {

	public $table = 'widget_instances';
    public $fillable = ['options', 'name', 'slug'];

    public function widget()
    {
        return $this->belongsTo('Conductor\Core\Widget\Model');
    }

    public function areas()
    {
        return $this->belongsToMany('Conductor\Core\Widget\Area', 'widget_area_instances', 'area_id', 'instance_id');
    }
}