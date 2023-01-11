<?php

namespace App\Services\Core;

use App\Repositories\Core\InterfaceRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @property \App\Repositories\InterfaceRepository $repository
 */
abstract class Service
{
    protected InterfaceRepository $repository;

    public function __construct(InterfaceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param  array  $columns
     * @param  array  $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->repository->all($columns, $relations);
    }

    /**
     * @param  int  $id
     * @return Model
     *
     * @throws ModelNotFoundException
     */
    public function findById(int $id): Model
    {
        try {
            return $this->repository->findById($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("'id:{$id}'は見つかりませんでした。", previous: $e);
        }
    }

    /**
     * @param  array  $attributes
     * @return Model
     *
     * @throws InvalidParameterException
     */
    public function create(array $attributes): Model
    {
        return $this->repository->create($attributes);
    }

    /**
     * @param  int  $id
     * @param  array  $attributes
     * @return Model
     *
     * @throws InvalidParameterException
     */
    public function update(int $id, array $attributes): Model
    {
        return $this->repository->update($id, $attributes);
    }

    /**
     * @param  int  $id
     * @return true
     *
     * @throws InvalidParameterException
     */
    public function delete(int $id): bool
    {
        return $this->repository->deleteById($id);
    }
}
