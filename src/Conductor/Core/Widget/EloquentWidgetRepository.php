<?php namespace Conductor\Core\Widget;

class EloquentWidgetRepository implements WidgetRepository {

    private $widget;

	private $area;

    private $instance;

    function __construct(Model $widget, Area $area, Instance $instance)
    {
        $this->widget = $widget;
		$this->area = $area;
        $this->instance = $instance;
    }

    public function getAll()
    {
        return $this->widget->all();
    }

	public function getAreas()
	{
		return $this->area->all();
	}

	public function findBySlug($slug)
	{
		return $this->widget->where('slug', $slug)->first();
	}

    public function findInstanceBySlug($slug)
    {
        return $this->instance->where('slug', $slug)->first();
    }

    public function findAreaBySlug($slug)
    {
        return $this->area->where('slug', $slug)->first();
    }

	public function create($widget)
	{
		$properties = ['name' => $widget->name, 'description' => $widget->description, 'slug' => $widget->slug];

		return $this->widget->create($properties);
	}

	public function isInDb($widget)
	{
		$widget = $this->findBySlug($widget->slug);
		if(isset($widget)) return true;

		return false;
	}
}