<?php namespace Conductor\Core\Widget;

interface WidgetRepository {

    public function getAll();

    public function getAreas();

    public function getAreasWithInstances();

    public function getInstances();

	public function create($widget);

    public function createArea($widget);

    public function isInDb($widget);

    public function findById($id);

	public function findBySlug($slug);

    public function findInstanceBySlug($slug);

    public function findAreaBySlug($slug);

    public function syncInstancesToArea(array $instanceIds, $area);
}