<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\PrestamoRepositoryInterface;
use App\Models\Prestamo;

class PrestamoRepository implements PrestamoRepositoryInterface
{
    public function create(array $data)
    {
        return Prestamo::create($data);
    }
    public function find(string $id)
    {
        return Prestamo::find($id);
    }
    public function userHasLoan(string $userId): bool
    {
        return Prestamo::where('identificacionUsuario', $userId)->exists();
    }

    public function getAll()
    {
        return Prestamo::all();
    }

    public function getByUser(string $userId)
    {
        return Prestamo::where('identificacionUsuario', $userId)->get();
    }
}
