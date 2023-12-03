<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function getOneById($id): ?array;

    public function getByIds(array $ids): array;

    public function getAll(): array;
}
