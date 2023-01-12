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
     * @param  array<string>  $columns
     * @param  array<string|\Closure>  $relations
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
     * モデルを作成する
     *
     * @param  array<mixed>  $payload
     * @return Model
     *
     * @throws \Exception
     */
    public function create(array $payload): Model
    {
        return $this->repository->create($payload);
    }

    /**
     * データをアップデートする
     *
     * @param  int|string  $id
     * @param  array<mixed>  $payload
     * @return Model
     *
     * @throws \Exception
     */
    public function update(int|string $id, array $payload): Model
    {
        return $this->repository->update($id, $payload);
    }

    /**
     * IDを使用して、データを削除する
     *
     * @param  int|string  $id
     * @return true
     *
     * @throws \Exception
     */
    public function delete(int|string $id): bool
    {
        return $this->repository->deleteById($id);
    }
}
