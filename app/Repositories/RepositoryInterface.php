<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getAll();

    public function getById($id);

    public function create($attribute = []);

    public function update($id, $attribute = []);

    public function updateWhereEqual($conditions, $attribute = []);

    public function delete($id);

    public function deleteWhereEqual($conditions);

    public function deleteWhereIn($column, $conditions);

    public function getWhereEqual($conditions, $relation = []);
}
