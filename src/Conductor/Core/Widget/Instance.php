<?php namespace Conductor\Core\Widget;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Instance extends Eloquent {

	public $table = 'widget_instances';

    public function widget()
    {
        return $this->belongsTo('Conductor\Core\Widget\Model');
    }
}