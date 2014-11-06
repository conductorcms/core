<?php namespace Conductor\Core\Repository;

interface BaseRepository {

    public function getAll();
    public function getAllWithRelationships(array $relationshps);
    public function find($id);
    public function findBy($field, $value);
    public function findWithRelationships($id, array $relationships);
    public function create($data);
    public function update($id, $data);
    public function destroy($id);
    public function destroyFromArray(array $ids);

}