<?php namespace Conductor\Core\Repository;

class BaseEloquentRepository implements BaseRepository {

    /**
     * Stores the model
     * @var
     */
    private $model;

    /**
     * Set the model in use
     * @param $model
     */
    function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve all records
     * @return mixed
     */
    public function getAll()
    {
        return $this->model->all();
    }

    public function getAllWithRelationships(array $relationships)
    {
        return $this->model->with($relationships)->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findBy($field, $value)
    {
        return $this->model->where($field, $value)->first();
    }

    /**
     * @param $id
     * @param array $relationships
     * @return mixed
     */
    public function findWithRelationships($id, array $relationships)
    {
        return $this->model->with($relationships)->find($id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $model = $this->find($id);

        return $this->updateEloquent($model, $data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param array $ids
     * @return bool
     */
    public function destroyFromArray(array $ids)
    {
        foreach($ids as $id)
        {
            $this->model->destroy($id);
        }

        return true;
    }

    public function isInDb($field, $value)
    {
        return ($this->model->where($field, $value)->count() > 0 ? true : false);
    }

    /**
     * @param $model
     * @param $data
     * @return mixed
     */
    private function updateEloquent($model, $data)
    {
        foreach($data as $key => $value)
        {
            if(isset($model->{$key})) $model->{$key} = $value;
        }

        return $model->save();
    }
}