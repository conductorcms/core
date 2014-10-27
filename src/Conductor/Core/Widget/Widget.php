<?php namespace Conductor\Core\Widget;

use Illuminate\Support\Str;
use Illuminate\Database\DatabaseManager as DB;
use Illuminate\Config\Repository as Config;
use Illuminate\View\Factory;

class Widget {

    private $optionsHandler;

	private $repository;

	private $db;

	private $config;

    private $view;

    function __construct(Options $options, WidgetRepository $repository, Str $str, DB $db, Config $config, Factory $view)
    {
        $this->optionsHandler =  $options;
		$this->repository = $repository;
		$this->db = $db;
		$this->config = $config;
        $this->view = $view;

		if(isset($this->name))
		{
			$this->slug = $str->slug($this->name);
		}

		if(isset($this->options))
		{
			$this->optionsHandler->setOptions($this->options);
		}
    }

    public function register()
    {
		if(!$this->tableExists('widgets')) return false;

        if(!$this->repository->isInDb($this))
		{
			$this->repository->create($this);
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

    public function getView()
    {

    }

	public function loadWidgetInstance($slug)
	{
        $instance = $this->repository->findInstanceBySlug($slug);

        $widget = $instance->widget;
        $data = json_decode($instance->options, true);

        $html = '<div class="widget '. $widget->slug . ' ' . $instance->slug .'">' . PHP_EOL;
        $html .= $this->view->make('widget.' . $widget->slug . '::index', $data) . PHP_EOL;
        $html .= '</div>' . PHP_EOL;

        return $html;
	}

	public function loadWidgetArea($slug)
	{
		$area = $this->repository->findAreaBySlug($slug);
        $html = '';
		foreach($area->widgetInstances as $instance)
		{
			$html .= $this->loadWidgetInstance($instance->slug) . PHP_EOL;
		}
        return $html;
	}

    public function getOptions()
    {
        return $this->options->getOptions();
    }

	public function tableExists($table)
	{
		$database = $this->config->get('database.connections.mysql.database');
		$prefix = $this->config->get('database.connections.mysql.prefix');

		if(count($this->db->select( "SELECT table_name FROM information_schema.tables WHERE table_schema = '" . $database . "' AND table_name = '" . $prefix . $table . "';" ) ) == 0 )
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}