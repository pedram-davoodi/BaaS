<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getOneById($id): ?array;

    public function getByIds(array $ids): array;

    public function getAll(): array;
}
