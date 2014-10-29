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
        $this->cache->tags('conductor:widgets')->flush();
		return $this->cache->tags('conductor:widgets')->rememberForever('conductor:widgets:all', function()
		{
			return $this->widget->getAll();
		});
	}

	public function getAreas()
	{
        $this->cache->forget('conductor:widget:areas');
		return $this->cache->rememberForever('conductor:widget:areas', function()
		{
			return $this->widget->getAreas();
		});
	}

    public function getAreasWithInstances()
    {
        $this->cache->forget('conductor:widget:areas-instances');
        return $this->cache->rememberForever('conductor:widget:areas-instances', function()
        {
            return $this->widget->getAreasWithInstances();
        });
    }

    public function getInstances()
    {
        $this->cache->forget('conductor:widget:instances');

        return $this->cache->rememberForever('conductor:widget:instances', function()
        {
            return $this->widget->getInstances();
        });
    }

	public function create($widget)
	{
		$widget = $this->widget->create($widget);

        $this->cache->tags('conductor:widgets')->flush();

        $this->getAll();

		return $this->cache->rememberForever('conductor:widget:' . $widget->slug, function() use ($widget)
		{
			return $widget;
		});
	}

    public function createArea($area)
    {
        $area = $this->widget->createArea($area);

        $this->cache->forget('conductor:widget:areas');

        $this->getAreas();

        return $this->cache->rememberForever('conductor:widget:area: ' . $area->slug, function() use($area)
        {
            return $area;
        });

    }

    public function createInstance($widget, $data)
    {
        $this->cache->forget('conductor:widget:instances');

        return $this->widget->createInstance($widget, $data);
    }

	public function isInDb($widget)
    {
        $this->cache->tags('conductor:widgets')->flush();
        return $this->cache->tags('conductor:widgets')->rememberForever('conductor:widget:' . $widget->slug . ':inDb', function() use ($widget)
		{
			return $this->widget->isInDb($widget);
		});
	}

    public function findById($id)
    {
        return $this->widget->findById($id);
    }

	public function findBySlug($slug)
	{
        $this->cache->forget('conductor:widget:' . $slug);
		return $this->cache->rememberForever('conductor:widget:' . $slug, function() use ($slug)
		{
			return $this->widget->findBySlug($slug);
		});
	}

    public function findInstanceBySlug($slug)
    {
        $this->cache->forget('conductor:widget:'.$slug.':instance');
        return $this->cache->rememberForever('conductor:widget:' . $slug . ':instance', function() use ($slug)
        {
            return $this->widget->findInstanceBySlug($slug);
        });
    }

    public function findAreaById($id)
    {
        $this->cache->forget('conductor:widget:area' . $id);
        return $this->cache->rememberForever('conductor:widget:area:' . $id, function() use ($id)
        {
            return $this->widget->findAreaById($id);
        });

    }

    public function findAreaBySlug($slug)
    {
        $this->cache->forget('conductor:widget:area' . $slug);
        return $this->cache->rememberForever('conductor:widget:area:' . $slug, function() use ($slug)
        {
            return $this->widget->findAreaBySlug($slug);
        });
    }

    public function syncInstancesToArea(array $instanceIds, $area)
    {
        $this->cache->tags('conductor:widget:instances')->flush();


        return $this->widget->syncInstancesToArea($instanceIds, $area);
    }

    public function destroyArea($id)
    {
        return $this->widget->destroyArea($id);
    }

}