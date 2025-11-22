<?php
namespace App\Infrastructure\Repositories;
use App\Domain\Repositories\PrestamoRepositoryInterface;
use App\Models\Prestamo;

class PrestamoRepository implements PrestamoRepositoryInterface {
  public function crear(array $data) {
    return Prestamo::create($data);
  }
  public function obtener(string $id) {
    return Prestamo::find($id);
  }
  public function usuarioTienePrestamo(string $identificacion): bool {
    return Prestamo::where('identificacionUsuario', $identificacion)->exists();
  }
}
