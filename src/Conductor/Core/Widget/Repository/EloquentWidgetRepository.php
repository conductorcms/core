<?php namespace Conductor\Core\Widget\Repository;

use Conductor\Core\Repository\BaseEloquentRepository;
use Conductor\Core\Widget\Model\Widget;

class EloquentWidgetRepository extends BaseEloquentRepository {

    private $widget;

    function __construct(Widget $widget)
    {
        $this->widget = $widget;

        parent::__construct($widget);
    }

}