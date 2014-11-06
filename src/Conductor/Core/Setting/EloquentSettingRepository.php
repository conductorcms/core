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

    public function findById($id)
    {
        return $this->setting->find($id);
    }

    public function create($options)
    {
        $setting = [
            'key' => $options['key'],
            'type' => $options['type'],
            'name' => $options['name'],
            'group' => $options['group'],
            'value' => $this->config->get($options['key'])
        ];

        return $this->setting->create($setting);
    }

    public function update($setting)
    {
        $settingModel = $this->findById($setting['id']);

        $settingModel->value = $setting['value'];

        return $settingModel->save();
    }

    // if the setting exists, return it
    // else return false
    public function exists($key)
    {
        $setting = $this->setting->whereKey($key)->get();
        return ($setting->count() > 0 ? $setting->first() : false);
    }

    public function updateFromArray(array $settings)
    {
        foreach ($settings as $setting)
        {
            $this->update($setting);
        }
    }
}