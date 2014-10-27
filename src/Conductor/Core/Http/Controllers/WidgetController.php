<?php namespace Conductor\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Conductor\Core\Widget\WidgetRepository;
use Response;
use Illuminate\Http\Request;

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
}