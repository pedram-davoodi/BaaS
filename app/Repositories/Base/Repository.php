<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Repository implements RepositoryInterface
{
    public function __construct(protected Model $model){}

    public function getOneById($id): ?Model
    {
        return $this->model->find($id);
    }

    public function getByIds(array $ids): ?Collection
    {
        return $this->model->find($ids)?->map(fn ($item) => collect($item->toArray()));
    }

    public function getAll(): ?Collection
    {
        return $this->model->all()?->map(fn ($item) => collect($item->toArray()));
    }

    public function paginate(int $paginate): LengthAwarePaginator
    {
        return $this->model->paginate($paginate);
    }

    public function getFirstWhere(...$params): ?Model
    {
        return $this->model->firstWhere(...$params);
    }

    public function update(array $data, ...$params): bool
    {
        return $this->model->where(...$params)->update($data);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function delete(...$params): bool
    {
        return $this->model->where(...$params)->delete();
    }

    public function updateOrCreate(array $attributes, array $values = []): Model
    {
        return $this->model->updateOrCreate($attributes, $values);
    }
}
