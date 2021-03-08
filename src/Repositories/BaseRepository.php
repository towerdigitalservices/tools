<?php

namespace TowerDigital\Tools\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve a Model by ID
     *
     * @param string $id
     *
     * @return Model
     */
    public function byId(string $id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Retrieve all Models
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Create a new Model
     *
     * @param Array $data
     *
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update a Model
     *
     * @param Array $data
     *
     * @return Model
     */
    public function update(string $id, array $data): Model
    {
        $model = $this->byId($id);
        $model->update($data);
        $model->refresh();
        return $model;
    }

    /**
     * Delete a Model
     *
     * @param string $id
     *
     * @return boolean
     */
    public function delete(string $id): bool
    {
        $model = $this->byId($id);
        return $model->delete();
    }

}