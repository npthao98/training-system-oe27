<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function getAll($relation = [])
    {
        return $this->model->with($relation)->get();
    }

    public function getById($id, $relation = [])
    {
        return $this->model->with($relation)->findOrFail($id);
    }

    public function create($attribute = [])
    {
        return $this->model->create($attribute);
    }

    public function update($id, $attribute = [])
    {
        $result = $this->getById($id);

        if ($result) {
            $result->update($attribute);

            return $result;
        }

        return false;
    }

    public function updateWhereEqual($conditions, $attribute = [])
    {
        $this->model->where($conditions)
            ->update($attribute);
    }

    public function delete($id)
    {
        $result = $this->getById($id);

        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    public function deleteWhereEqual($conditions)
    {
        $this->model->where($conditions)
            ->delete();
    }

    public function deleteWhereIn($column, $conditions)
    {
        $this->model->whereIn($column, $conditions)
            ->delete();
    }

    public function getWhereEqual($conditions, $relation = [])
    {
        return $this->model->where($conditions)
            ->with($relation)->get();
    }
}
