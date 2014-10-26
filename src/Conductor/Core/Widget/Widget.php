<?php namespace Conductor\Core\Widget;

class Widget {

    private $options;

    function __construct(Options $options)
    {
        $this->options =  $options;
    }

    public function register($widget)
    {
        $this->addWidget($widget);
    }

    private function addWidget($widget)
    {
        static::$registered[] = $widget->getName();
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

    public function getOptions()
    {
        return $this->options->getOptions();
    }
}