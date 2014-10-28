<?php namespace Conductor\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Conductor\Core\Widget\WidgetRepository;
use Response;
use Illuminate\Http\Request;

class WidgetAreaController extends Controller {

    private $repository;

    private $request;

    function __construct(WidgetRepository $repository, Request $request)
    {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function all()
    {
        return Response::json(['areas' => $this->repository->getAreasWithInstances()], 200);
    }

    public function store()
    {
        $area = $this->request->only(['name', 'slug']);

        $this->repository->createArea($area);

        return Response::json(['message' => 'Area created successfully'], 201);
    }

    public function destroy($id)
    {
        $this->repository->destroyArea($id);
    }

    public function syncInstances($id)
    {
        $area = $this->repository->findAreaById($id);

        $instances = $this->request->only(['instances']);

        $this->repository->syncInstancesToArea($instances['instances'], $area);

        return Response::json(['message' => 'Instances synchronized successfully'], 200);
    }



}