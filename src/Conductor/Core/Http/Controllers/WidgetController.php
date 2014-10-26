<?php namespace Conductor\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Conductor\Core\Widget\WidgetRepository;
use Response;

class WidgetController extends Controller {

	private $repository;

	function __construct(WidgetRepository $repository)
	{
		$this->repository = $repository;
	}

	public function all()
	{
		return  Response::json(['widgets' => $this->repository->getAll()], 200);
	}

	public function areas()
	{
		return  Response::json(['areas' => $this->repository->getAreas()], 200);
	}


}