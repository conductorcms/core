<?php namespace Conductor\Core\Widget;

use Illuminate\Cache\Repository;

class CacheWidgetRepository implements WidgetRepository
{

	private $widget;

	private $cache;

	function __construct(EloquentWidgetRepository $widget, Repository $cache)
	{
		$this->widget = $widget;
		$this->cache = $cache;
	}

	public function getAll()
	{
		return $this->cache->rememberForever('conductor:widgets:all', function()
		{
			return $this->widget->getAll();
		});
	}

	public function getAreas()
	{
		return $this->cache->rememberForever('conductor:widgets:areas', function()
		{
			return $this->widget->getAreas();
		});
	}

	public function create($widget)
	{
		$widget = $this->widget->create($widget);

		$this->cache->forget('conductor:widgets:all');

		$allWidgets = $this->cache->rememberForever('conductor:widgets:all', function()
		{
			return $this->widget->getAll();
		});

		return $this->cache->rememberForever('conductor:widget:' . $widget->slug, function() use ($widget)
		{
			return $widget;
		});
	}

	public function isInDb($widget)
	{
		return $this->cache->rememberForever('conductor:widget:' . $widget->slug . ':inDb', function() use ($widget)
		{
			return $this->widget->isInDb($widget);
		});
	}

	public function findBySlug($slug)
	{
		return $this->cache->rememberForever('conductor:widget:' . $slug, function() use ($slug)
		{
			return $this->widget->findBySlug($slug);
		});
	}

}