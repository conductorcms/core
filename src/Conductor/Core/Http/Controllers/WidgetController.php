<?php namespace Conductor\Core\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Conductor\Core\Widget\Repository\EloquentWidgetRepository as Widget;
use Response;

class WidgetController extends Controller {

    private $app;

	private $repository;

    private $request;

	function __construct(Application $app, Widget $repository, Request $request)
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
        $widget = $this->repository->find($id);

        $widget = $this->app->make('conductor:widget:' . $widget->slug);

        return $widget->options;
    }
}