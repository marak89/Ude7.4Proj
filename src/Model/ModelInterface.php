<?php

declare(strict_types=1);

namespace App\Model;

interface ModelInterface
{
    public function list(
        int    $pageNumber,
        int    $pageSize,
        string $sortBy,
        string $sortOrder,
        string $phrase = null
    ): array;
    public function count(string $phrase = null): int;
    public function get(int $id): array;
    public function create(array $data): bool;
    public function edit(int $id, array $note): bool;
    public function delete(int $id): void;
}