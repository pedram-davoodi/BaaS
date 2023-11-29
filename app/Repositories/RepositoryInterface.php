<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function getOneById($id): ?Model;

    public function getByIds(array $ids): Collection;

    public function getAll(): Collection;

    public function paginate(int $paginate): LengthAwarePaginator;
}
