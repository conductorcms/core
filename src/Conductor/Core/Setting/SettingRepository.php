<?php namespace Conductor\Core\Setting;

interface SettingRepository {

    public function getAll();
    public function update($setting, $settingId);
    public function create($options);
    public function exists($key);

}