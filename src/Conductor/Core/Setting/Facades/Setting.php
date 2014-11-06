<?php namespace Conductor\Core\Setting\Facades;

use Illuminate\Support\Facades\Facade;

class Setting extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'setting';
    }

}