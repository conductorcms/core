<?php namespace Conductor\Core\Widget;

use Illuminate\Support\Str;
use Illuminate\Database\DatabaseManager as DB;
use Illuminate\Config\Repository as Config;
use Illuminate\View\Factory;
use Conductor\Core\Widget\Repository\EloquentWidgetRepository as WidgetRepository;
use Conductor\Core\Widget\Repository\EloquentWidgetAreaRepository as Area;
use Conductor\Core\Widget\Repository\EloquentWidgetInstanceRepository as Instance;

class Widget {

    private $repository;

    private $db;

    private $config;

    private $view;

    function __construct(Area $area, Instance $instance, WidgetRepository $repository, Str $str, DB $db, Config $config, Factory $view)
    {
        $this->area = $area;
        $this->instance = $instance;
        $this->repository = $repository;
        $this->db = $db;
        $this->config = $config;
        $this->view = $view;

        if(isset($this->name))
        {
            $this->slug = $str->slug($this->name);
        }
    }

    public function register()
    {
        if(!$this->tableExists('widgets')) return false;

        if(!$this->repository->isInDb('slug', $this->slug))
        {
            return $this->repository->create((array)$this);
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getWidgets()
    {
        return static::$registered;
    }


    public function loadWidgetInstance($slug)
    {
        $instance = $this->instance->findBy('slug', $slug);

        $widget = $instance->widget;

        $data = json_decode($instance->options, true);

        $html = '<div class="widget ' . $widget->slug . ' ' . $instance->slug . '">' . PHP_EOL;
        $html .= $this->view->make('widget.' . $widget->slug . '::index', $data) . PHP_EOL;
        $html .= '</div>' . PHP_EOL;

        return $html;
    }

    public function loadWidgetArea($slug)
    {
        $area = $this->area->findBy('slug', $slug);
        $html = '';
        foreach ($area->instances as $instance)
        {
            $html .= $this->loadWidgetInstance($instance->slug) . PHP_EOL;
        }
        return $html;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function tableExists($table)
    {
        $database = $this->config->get('database.connections.mysql.database');
        $prefix = $this->config->get('database.connections.mysql.prefix');

        if(count($this->db->select("SELECT table_name FROM information_schema.tables WHERE table_schema = '" . $database . "' AND table_name = '" . $prefix . $table . "';")) == 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}