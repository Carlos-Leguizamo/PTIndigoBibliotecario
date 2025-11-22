<?php

namespace App\Domain\Repositories;

interface PrestamoRepositoryInterface
{
    public function create(array $data);
    public function find(string $id);
    public function userHasLoan(string $userId): bool;
    public function getAll();
    public function getByUser(string $userId);
}
