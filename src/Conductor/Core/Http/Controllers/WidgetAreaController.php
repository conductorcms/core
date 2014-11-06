<?php namespace Conductor\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Conductor\Core\Widget\Repository\EloquentWidgetAreaRepository as Area;
use Response;

class WidgetAreaController extends Controller {

    private $repository;

    private $request;

    function __construct(Area $repository, Request $request)
    {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function all()
    {
        return Response::json(['areas' => $this->repository->getAllWithRelationships(['instances'])], 200);
    }

    public function store()
    {
        $area = $this->request->only(['name', 'slug']);

        $this->repository->create($area);

        return Response::json(['message' => 'Area created successfully'], 201);
    }

    public function destroy($id)
    {
        $this->repository->destroy($id);
    }

    public function syncInstances($id)
    {
        $area = $this->repository->find($id);

        $instances = $this->request->only(['instances']);

        $this->repository->syncInstancesToArea($instances['instances'], $area);

        return Response::json(['message' => 'Instances synchronized successfully'], 200);
    }


}