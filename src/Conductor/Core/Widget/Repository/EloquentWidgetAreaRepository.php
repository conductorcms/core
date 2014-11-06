<?php namespace Conductor\Core\Widget\Repository;

use Conductor\Core\Repository\BaseEloquentRepository;
use Conductor\Core\Widget\Model\Area;

class EloquentWidgetAreaRepository extends BaseEloquentRepository {

    private $area;

    function __construct(Area $area)
    {
        $this->area = $area;

        parent::__construct($area);
    }

    public function syncInstancesToArea(array $instanceIds, $area)
    {
        return $area->instances()->sync($instanceIds);
    }

}