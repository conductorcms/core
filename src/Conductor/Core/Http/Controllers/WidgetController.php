<?php namespace Conductor\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Conductor\Core\Widget\WidgetRepository;
use Response;
use Symfony\Component\HttpFoundation\Request;

class WidgetController extends Controller {

	private $repository;

    private $request;

	function __construct(WidgetRepository $repository, Request $request)
	{
		$this->repository = $repository;
        $this->request = $request;
	}

	public function all()
	{
		return  Response::json(['widgets' => $this->repository->getAll()], 200);
	}

	public function areas()
	{
		return Response::json(['areas' => $this->repository->getAreas()], 200);
	}

    public function storeArea()
    {
        $area = $this->request->only(['name', 'slug']);

        $this->repository->createArea($area);

        return Response::json(['message' => 'Area created successfully'], 201);
    }

    public function destroyArea($id)
    {

    }


}