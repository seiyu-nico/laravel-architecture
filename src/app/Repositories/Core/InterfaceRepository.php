<?php

namespace App\Repositories\Core;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface InterfaceRepository
{
    /**
     * 全部のデータを取得する.
     *
     * @param  array<string>  $columns
     * @param  array<string|\Closure>  $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * 指定した条件に合ってるデータを取得する
     *
     * @param  array<string>  $columns
     * @param  array<string, \Closure|string|int>  $conditions
     * @param  array<string|\Closure>  $relations
     * @param  array<string>  $orders
     * @param  int|null  $limit
     * @return Collection
     */
    public function findWithConditions(array $columns = ['*'], array $conditions = [], array $relations = [], array $orders = [], int|null $limit = null): Collection;

    /**
     * 指定した条件に合ってるデータを取得する(ページネーション)
     *
     * @param  array<string>  $columns
     * @param  array<string>|\Closure  $conditions
     * @param  array<string|\Closure>  $relations
     * @param  array<string>  $orders
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
    ): LengthAwarePaginator;

    /**
     * 指定した条件に合ってるデータを取得する
     *
     * @param  array<string>  $columns
     * @param  array<string, \Closure|string|int>  $conditions
     * @param  array<string|\Closure>  $relations
     * @return Model|null
     */
    public function findOneWithConditions(array $columns = ['*'], array $conditions = [], array $relations = []): ?Model;

    /**
     * IDを使用して、１行のデータを取得する
     *
     * @param  int|string  $id
     * @param  array<string>  $columns
     * @param  array<string|\Closure>  $relations
     * @param  array<string>  $appends
     * @return Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findById(
        int|string $id,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): Model;

    /**
     * モデルを作成する
     *
     * @param  array<mixed>  $payload
     * @return Model
     *
     * @throws \Exception
     */
    public function create(array $payload): Model;

    /**
     * データをアップデートする
     *
     * @param  int|string  $id
     * @param  array<mixed>  $payload
     * @return Model
     *
     * @throws \Exception
     */
    public function update(int|string $id, array $payload): Model;

    /**
     * データを挿入または更新する
     *
     * @param  array<mixed>  $attributes
     * @param  array<mixed>  $values
     * @return Model
     */
    public function updateOrCreate(array $attributes, array $values): Model;

    /**
     * IDを使用して、データを削除する
     *
     * @param  int|string  $id
     * @return true
     *
     * @throws \Exception
     */
    public function deleteById(int|string $id): bool;
}
