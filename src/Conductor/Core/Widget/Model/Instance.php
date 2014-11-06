<?php namespace Conductor\Core\Widget\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Instance extends Eloquent {

    public $table = 'widget_instances';
    public $fillable = ['options', 'name', 'slug', 'widget_id'];

    public function widget()
    {
        return $this->belongsTo('Conductor\Core\Widget\Model\Widget');
    }

    public function areas()
    {
        return $this->belongsToMany('Conductor\Core\Widget\Model\Area', 'widget_area_instances', 'area_id', 'instance_id');
    }
}