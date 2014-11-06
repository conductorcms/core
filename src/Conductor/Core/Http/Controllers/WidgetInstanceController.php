<?php namespace Conductor\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Conductor\Core\Widget\Repository\EloquentWidgetInstanceRepository as Instance;
use Conductor\Core\Widget\Repository\EloquentWidgetRepository as Widget;
use Response;

class WidgetInstanceController extends Controller {

    private $instance;

    private $request;

    private $widget;

    function __construct(Instance $instance, Request $request, Widget $widget)
    {
        $this->instance = $instance;
        $this->request = $request;
        $this->widget = $widget;
    }

    public function all()
    {
        return Response::json(['instances' => $this->instance->getAllWithRelationships(['widget'])], 200);
    }

    public function get($id)
    {
        return Response::json(['instance' => $this->instance->findWithRelationships($id, ['widget'])], 200);
    }

    public function store($id)
    {
        $data = $this->request->only(['options', 'name', 'slug']);
        $data['options'] = json_encode($data['options']);

        $widget = $this->widget->find($id);

        $data['widget_id'] = $widget->id;

        $instance = $this->instance->create($data);
    }

    public function destroy($id)
    {
        $this->instance->destroy($id);

        return Response::json(['message' => 'Instance deleted successfully'], 200);
    }

}