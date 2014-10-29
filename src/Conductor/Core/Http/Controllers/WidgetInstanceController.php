<?php namespace Conductor\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Conductor\Core\Widget\WidgetRepository;
use Response;
use Illuminate\Http\Request;

class WidgetInstanceController extends Controller {

    private $repository;

    private $request;

    function __construct(WidgetRepository $repository, Request $request)
    {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function all()
    {
        return Response::json(['instances' => $this->repository->getInstances()], 200);
    }

    public function store($id)
    {
        $data = $this->request->only(['options', 'name', 'slug']);
        $data['options'] = json_encode($data['options']);

        $widget = $this->repository->findById($id);

        $instance = $this->repository->createInstance($widget, $data);
    }

}