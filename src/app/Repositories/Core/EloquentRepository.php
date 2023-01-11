<?php

namespace App\Repositories\Core;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentRepository implements InterfaceRepository
{
    protected Model $model;

    /**
     * BaseRepository constructor.
     *
     * @param  Model  $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * 全部のデータを取得する.
     *
     * @param  array  $columns
     * @param  array  $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * 指定した条件に合ってるデータを取得する
     *
     * @param  array  $columns
     * @param  array  $conditions
     * @param  array  $relations
     * @param  array  $orders
     * @param  int|null  $limit
     * @return Collection
     */
    public function findWithConditions(array $columns = ['*'], array $conditions = [], array $relations = [], array $orders = [], int|null $limit = null): Collection
    {
        $model = $this->model->with($relations)->where($conditions);
        foreach ($orders as $key => $direction) {
            $model->orderBy($key, $direction);
        }

        if ($limit) {
            $model->limit($limit);
        }

        return $model->get($columns);
    }

    /**
     * 指定した条件に合ってるデータを取得する(ページネーション)
     *
     * @param  array  $columns
     * @param  array|\Closure  $conditions
     * @param  array  $relations
     * @param  array  $orders
     * @param  int  $per_page
     * @param  int  $page
     * @return LengthAwarePaginator
     */
    public function findWithConditionsAndPagination(
        array $columns = ['*'],
        array|\Closure $conditions = [],
        array $relations = [],
        array $orders = [],
        int $per_page = 15,
        int $page = 1
    ): LengthAwarePaginator {
        $query = $this->model->with($relations);
        if (is_array($conditions)) {
            $query->where($conditions);
        } else {
            call_user_func($conditions, $query);
        }
        $query->select($columns);
        foreach ($orders as $key => $direction) {
            $query->orderBy($key, $direction);
        }

        return $query->paginate(perPage: $per_page, page: $page);
    }

    /**
     * 指定した条件に合ってるデータを取得する
     *
     * @param  array  $columns
     * @param  array  $conditions
     * @param  array  $relations
     * @return Model|null
     */
    public function findOneWithConditions(array $columns = ['*'], array $conditions = [], array $relations = []): ?Model
    {
        $model = $this->model->with($relations)->where($conditions);

        return $model->first($columns);
    }

    /**
     * モデルを作成する
     *
     * @param  array  $payload
     * @return Model
     *
     * @throws \Exception
     */
    public function create(array $payload): Model
    {
        $model = $this->model->create($payload);

        if (is_null($model)) {
            throw new \Exception('不正なパラメータ');
        }

        return $model->fresh();
    }

    /**
     * データをアップデートする
     *
     * @param  int|string  $id
     * @param  array  $payload
     * @return Model
     *
     * @throws \Exception
     */
    public function update(int|string $id, array $payload): Model
    {
        $model = $this->model->find($id);

        if (is_null($model)) {
            throw new \Exception('不正なID');
        }

        $result = $model->update($payload);

        if (! $result) {
            throw new \Exception('不正なパラメータ');
        }

        return $model;
    }

    /**
     * データを挿入または更新する
     *
     * @param  array  $attributes
     * @param  array  $values
     * @return Model
     */
    public function updateOrCreate(array $attributes, array $values): Model
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * IDを使用して、データを削除する
     *
     * @param  int|string  $id
     * @return true
     *
     * @throws \Exception
     */
    public function deleteById(int|string $id): bool
    {
        if (! $this->findById($id)->delete()) {
            throw new \Exception('不正なID');
        }

        return true;
    }

    /**
     * IDを使用して、１行のデータを取得する
     *
     * @param $id
     * @param  array  $columns
     * @param  array  $relations
     * @param  array  $appends
     * @return Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findById(
        $id,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): Model {
        return $this->model->query()->select($columns)->with($relations)->findOrFail($id)->append($appends);
    }
}
