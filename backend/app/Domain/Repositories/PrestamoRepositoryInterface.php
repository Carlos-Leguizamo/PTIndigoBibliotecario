<?php
namespace App\Domain\Repositories;
interface PrestamoRepositoryInterface {
  public function crear(array $data);
  public function obtener(string $id);
  public function usuarioTienePrestamo(string $identificacion): bool;
}
