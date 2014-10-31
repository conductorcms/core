<?php namespace Conductor\Core\Setting;

use Illuminate\Config\Repository as Config;
use Illuminate\Database\DatabaseManager as DB;

// collect setting registrations
// loop through, check if  it's a valid
// config key. If it is, check if it exists in DB.
// if it does, set config to DB value
// if it doesn't, add to DB, set value
// to config.

class Setting {

    // store application settings
    public static $settings = [];
    public $tableExists;

    public $config;
    public $db;
    public $settingRepository;


    function __construct(Config $config, DB $db, SettingRepository $setting)
    {
        $this->config = $config;
        $this->db = $db;
        $this->settingRepository = $setting;

        $this->tableExists = $this->checkTable('settings');
    }

    private function checkTable($name)
    {
        $connection = $this->config->get('database.default');
        $db = $this->config->get('database.connections.' . $connection . '.database');
        $result = $this->db->table('information_schema.tables')->where('table_schema', $db)->where('table_name', $name)->get();

        return (count($result) > 0 ? true : false);
    }


    public function register($key, $type)
    {
        if(!$this->tableExists) return false;

        // if config doesn't exist, throw an exception
        if(!$this->config->has($key)) return false;

        // if it doesn't exist in the DB, create it
        if(!$setting = $this->settingRepository->exists($key))
        {
            $setting = $this->settingRepository->create($key, $type);
            $this->addSetting($setting);
            return true;
        }

        // if it exists, load value
        $this->config->set($key, $setting->value);
        $this->addSetting($setting);
    }

    public function getSettings()
    {
        return static::$settings;
    }

    private function addSetting($setting)
    {
        static::$settings[$setting->key] = $setting;
    }
}