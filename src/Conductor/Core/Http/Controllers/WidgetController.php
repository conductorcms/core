<?php namespace Conductor\Core\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Controller;
use Conductor\Core\Widget\WidgetRepository;
use Response;
use Illuminate\Http\Request;

class WidgetController extends Controller {

    private $app;

	private $repository;

    private $request;

	function __construct(Application $app, WidgetRepository $repository, Request $request)
	{
        $this->app = $app;
		$this->repository = $repository;
        $this->request = $request;
	}

	public function all()
	{
		return Response::json(['widgets' => $this->repository->getAll()], 200);
	}

    public function getOptions($id)
    {
        $widget = $this->repository->findById($id);

        $widget = $this->app->make('conductor:widget:' . $widget->slug);

        return $widget->options;
    }
}