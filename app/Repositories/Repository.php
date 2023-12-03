<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class Repository implements RepositoryInterface
{
    protected Model $model;

    protected string $modelClass;

    public function __construct()
    {
        $this->model = app($this->modelClass);
    }

    public function getOneById($id): ?array
    {
        return $this->model->find($id)->first()?->toArray();
    }

    public function getByIds(array $ids): array
    {
        return $this->model->find($ids)?->toArray();
    }

    public function getAll(): array
    {
        return $this->model->all()?->toArray();
    }

    public function paginate(int $paginate): LengthAwarePaginator
    {
        return $this->model->paginate($paginate);
    }

    public function getFirstWhere(...$params): ?Model
    {
        return $this->model->firstWhere(...$params);
    }

    public function getModelClass(): string
    {
        return $this->modelClass;
    }
}
