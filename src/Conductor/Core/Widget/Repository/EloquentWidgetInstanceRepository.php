<?php namespace Conductor\Core\Widget\Repository;

use Conductor\Core\Repository\BaseEloquentRepository;
use Conductor\Core\Widget\Model\Instance;

class EloquentWidgetInstanceRepository extends BaseEloquentRepository {

    private $instance;

    function __construct(Instance $instance)
    {
        $this->instance = $instance;

        parent::__construct($instance);
    }

}