<?php namespace Conductor\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Setting;

class SettingController extends Controller {

    function getAll()
    {
        return Setting::getSettings();
    }


}