<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function getOneById($id): ?Collection;

    public function getByIds(array $ids): ?Collection;

    public function getAll(): ?Collection;
}
