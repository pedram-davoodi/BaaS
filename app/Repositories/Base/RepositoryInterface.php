<?php

namespace App\Repositories\Base;

use App\ModelInterfaces\Base\ModelInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function first(): ?ModelInterface;

    public function getOneByIdOrFail($id): ?ModelInterface;

    public function getOneById($id): ?ModelInterface;

    public function getOneByIdOrFailWithTrashed($id): ?ModelInterface;

    public function getByIds(array $ids): ?Collection;

    public function getAll(): ?Collection;

    public function paginate(int $paginate): LengthAwarePaginator;

    public function getFirstWhere(...$params): ?ModelInterface;

    public function update(array $data, ...$params): bool;

    public function create(array $data): ModelInterface;

    public function insert(array $data): bool;

    public function delete($id, ...$params): bool;

    public function updateOrCreate(array $attributes, array $values = []): ModelInterface;
}
