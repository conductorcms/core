<?php namespace Conductor\Core\Widget;

interface WidgetRepository {

    public function getAll();

	public function create($widget);

	public function findBySlug($slug);


}