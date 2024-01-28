<?php

namespace App\Repositories\Base;

use App\ModelInterfaces\Base\ModelInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function getOneById($id): ?ModelInterface;

    public function getOneByIdWithTrashed($id): ?ModelInterface;

    public function getByIds(array $ids): ?Collection;

    public function getAll(): ?Collection;

    public function paginate(int $paginate): LengthAwarePaginator;

    public function getFirstWhere(...$params): ?ModelInterface;

    public function update(array $data, ...$params): bool;

    public function create(array $data): ModelInterface;

    public function delete($id, ...$params): bool;

    public function updateOrCreate(array $attributes, array $values = []): ModelInterface;
}
