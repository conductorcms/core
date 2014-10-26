<?php namespace Conductor\Core\Widget;

use Illuminate\Support\Str;
use Illuminate\Database\DatabaseManager as DB;
use Illuminate\Config\Repository as Config;

class Widget {

    private $optionsHandler;

	private $repository;

	private $db;

	private $config;

    function __construct(Options $options, WidgetRepository $repository, Str $str, DB $db, Config $config)
    {
        $this->optionsHandler =  $options;
		$this->repository = $repository;
		$this->db = $db;
		$this->config = $config;

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

	public function buildInstanceView($slug)
	{
		$instance = $this->repository->getInstanceBySlug($slug);

		$data = $instance->buildViewData();

		return View::make('conductor:widget:' . $slug, $data);
	}

	public function buildAreaView($slug)
	{
		$area = $this->repository->getAreaBySlug($slug);

		foreach($area->widgetInstance as $instance)
		{
			$this->buildInstanceView($instance->slug);
		}
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