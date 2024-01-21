<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function getOneById($id): ?Model;

    public function getByIds(array $ids): ?Collection;

    public function getAll(): ?Collection;

    public function paginate(int $paginate): LengthAwarePaginator;

    public function getFirstWhere(...$params): ?Model;

    public function update(array $data, ...$params): bool;

    public function create(array $data): Model;

    public function delete($id, ...$params): bool;

    public function updateOrCreate(array $attributes, array $values = []): Model;
}
