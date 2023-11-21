<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

abstract class Repository implements RepositoryInterface
{
    protected Model $model;

    /**
     * @param string $modelClass
     */
    public function __construct(private readonly string $modelClass)
    {
        $this->model = app($this->modelClass);
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function getOneById($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @param array $ids
     * @return Collection
     */
    public function getByIds(array $ids): Collection
    {
        return $this->model->find($ids);
    }

    /**
     * @return Collection|
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param int $paginate
     * @return LengthAwarePaginator
     */
    public function paginate(int $paginate): LengthAwarePaginator
    {
        return $this->model->paginate($paginate);
    }

    /**
     * @param ...$params
     * @return Model|null
     */
    public function getFirstWhere(...$params): ?Model
    {
        return $this->model->firstWhere(...$params);
    }

    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return $this->modelClass;
    }
}
