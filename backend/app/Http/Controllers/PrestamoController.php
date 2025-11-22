<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\PrestamoRequest;
use App\Domain\Services\PrestamoService;
use Illuminate\Http\Request;

class PrestamoController extends Controller {
  public function __construct(private PrestamoService $service) {}

  public function store(PrestamoRequest $request) {
    $prestamo = $this->service->crearPrestamo($request->validated());
    return response()->json(['id'=>$prestamo->id,'fechaMaximaDevolucion'=>$prestamo->fechaMaximaDevolucion], 201);
  }

  public function show($id) {
    $p = $this->service->obtenerPrestamo($id);
    if (!$p) return response()->json(['mensaje'=>'El préstamo no existe'], 404);
    return response()->json([
      'id'=>$p->id,
      'isbn'=>$p->isbn,
      'identificacionUsuario'=>$p->identificacionUsuario,
      'tipoUsuario'=>$p->tipoUsuario,
      'fechaMaximaDevolucion'=>$p->fechaMaximaDevolucion,
    ]);
  }
}
