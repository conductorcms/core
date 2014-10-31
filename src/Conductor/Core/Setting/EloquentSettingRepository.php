<?php namespace Conductor\Core\Setting;

use Illuminate\Database\Schema\Builder as Builder;
use Illuminate\Config\Repository as Config;
use Conductor\Core\Setting\Model as SettingModel;
use Illuminate\Foundation\Application;

class EloquentSettingRepository implements SettingRepository {

    private $config;

    private $setting;


    function __construct(Config $config, SettingModel $setting)
    {
        $this->setting = $setting;
        $this->config = $config;
    }

    public function getAll()
    {
        return $this->setting->all();
    }

    public function create($key, $type)
    {
        $setting = [
            'key' => $key,
            'type' => $type,
            'value' => $this->config->get($key)
        ];

        return $this->setting->create($setting);
    }

    public function update($setting, $settingId)
    {

    }

    // if the setting exists, return it
    // else return false
    public function exists($key)
    {
        $setting = $this->setting->whereKey($key)->get();
        return ($setting->count() > 0 ? $setting->first() : false);
    }
}