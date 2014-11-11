<?php namespace Conductor\Core\Setting;

interface SettingRepository {

    public function getAll();

    public function findById($id);

    public function update($setting);

    public function create($options);

    public function exists($key);

    public function updateFromArray(array $settings);

}