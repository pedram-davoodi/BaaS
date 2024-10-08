<?php

namespace App\Repositories\Base;

use App\ModelInterfaces\Base\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\User\app\Models\User;

class EloquentRepository implements RepositoryInterface
{
    public function __construct(protected Model $model){}

    public function getOneByIdOrFail($id): ?ModelInterface
    {
        $model = $this->model->where($this->model->getKeyName() , $id)->first();
        if (empty($model)) {
            abort(404);
        }
        return $model;
    }

    public function first(): ?ModelInterface
    {
        return $this->model->first() ?? null;
    }

    public function getOneByIdOrFailWithTrashed($id): ?ModelInterface
    {
        $model = $this->model->where($this->model->getKeyName() , $id)->withTrashed()->first();
        if (empty($model)) {
            abort(404);
        }
        return $model;
    }

    public function getByIds(array $ids): ?Collection
    {
        return $this->model->find($ids)?->map(fn ($item) => collect($item->toArray()));
    }

    public function getAll(): ?Collection
    {
        return $this->model->all();
    }

    public function paginate(int $paginate): LengthAwarePaginator
    {
        return $this->model->paginate($paginate);
    }

    public function getFirstWhere(...$params): ?ModelInterface
    {
        return $this->model->firstWhere(...$params);
    }

    public function update(array $data, ...$params): bool
    {
        return $this->model->where(...$params)->update($data);
    }

    public function create(array $data): ModelInterface
    {
        return $this->model->create($data);
    }

    public function delete(...$params): bool
    {
        return $this->model->where(...$params)->delete();
    }

    public function updateOrCreate(array $attributes, array $values = []): ModelInterface
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    public function faker()
    {
        return $this->model::factory();
    }

    public function getOneById($id): ?ModelInterface
    {
        return $this->model->where($this->model->getKeyName() , $id)->first();
    }

    public function insert(array $data): bool
    {
        return $this->model->insert($data);
    }
}
