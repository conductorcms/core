<?php namespace Conductor\Core\Setting;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent {

    public $table = 'settings';
    public $fillable = ['key', 'value', 'type'];
    public $timestamps = false;

}