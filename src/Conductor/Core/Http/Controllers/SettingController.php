<?php namespace Conductor\Core\Http\Controllers;

use Conductor\Core\Setting\SettingRepository;
use Illuminate\Routing\Controller;
use Setting;
use Illuminate\Http\Request;

class SettingController extends Controller {

    private $request;

    private $setting;

    function __construct(Request $request, SettingRepository $setting)
    {
        $this->request = $request;
        $this->setting = $setting;
    }

    function getAll()
    {
        return Setting::getSettings();
    }

    function storeBatch()
    {
        $settings = $this->request->only('settings');

        return $this->setting->updateFromArray($settings['settings']);
    }


}