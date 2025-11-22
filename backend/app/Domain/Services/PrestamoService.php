<?php
namespace App\Domain\Services;
use App\Domain\Repositories\PrestamoRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;

class PrestamoService {
  public function __construct(private PrestamoRepositoryInterface $repo) {}

  public function crearPrestamo(array $data) {
    if ($data['tipoUsuario'] == 3 && $this->repo->usuarioTienePrestamo($data['identificacionUsuario'])) {
      throw new HttpResponseException(response()->json(['mensaje'=>'El usuario ya tiene un libro prestado'], 400));
    }

    $fecha = $this->calcularFechaDevolucion((int)$data['tipoUsuario']);
    $payload = [
      'isbn' => $data['isbn'],
      'identificacionUsuario' => $data['identificacionUsuario'],
      'tipoUsuario' => $data['tipoUsuario'],
      'fechaMaximaDevolucion' => $fecha
    ];

    return $this->repo->crear($payload);
  }

  public function obtenerPrestamo(string $id) {
    return $this->repo->obtener($id);
  }

  private function calcularFechaDevolucion(int $tipo): string {
    $dias = match($tipo) {
      1 => 10,
      2 => 8,
      3 => 7,
      default => 7,
    };

    $fecha = Carbon::now();
    $agregados = 0;
    while ($agregados < $dias) {
      $fecha = $fecha->addDay();
      if (!in_array($fecha->dayOfWeekIso, [6,7])) {
        $agregados++;
      }
    }
    return $fecha->toDateString();
  }
}
