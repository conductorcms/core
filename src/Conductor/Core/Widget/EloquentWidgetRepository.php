<?php namespace Conductor\Core\Widget;

class EloquentWidgetRepository implements WidgetRepository {

    private $widget;

    function __construct(Model $widget)
    {
        $this->widget = $widget;
    }

    public function getAll()
    {
        return $this->widget->all();
    }

}