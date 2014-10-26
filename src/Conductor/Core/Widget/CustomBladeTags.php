<?php namespace Conductor\Core\Widget;

use Illuminate\View\Compilers\BladeCompiler;

class CustomBladeTags {

	private $blade;

	function __construct(BladeCompiler $blade)
	{
		$this->blade = $blade;
	}

	public function registerAll()
	{
		$this->registerWidgetArea();
		$this->registerWidgetInstance();
	}

	private function registerWidgetArea()
	{
		$this->blade->extend(function($view, $compiler)
		{
			$pattern = $compiler->createMatcher('widgetInstance');

			return preg_replace($pattern, '$1<?php echo loadWidgetInstance($2); ?>', $view);
		});
	}

	private function registerWidgetInstance()
	{
		$this->blade->extend(function($view, $compiler)
		{
			$pattern = $compiler->createMatcher('widgetArea');

			return preg_replace($pattern, '$1<?php echo loadWidgetArea($2); ?>', $view);
		});
	}




}