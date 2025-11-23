<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\PrestamoRequest;
use App\Domain\Services\PrestamoService;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{
    public function __construct(private PrestamoService $service) {}

    public function store(PrestamoRequest $request)
    {
        try {
            $loan = $this->service->createLoan($request->validated());
            return response()->json([
                'id' => $loan->id,
                'returnDate' => $loan->fechaMaximaDevolucion
            ], 201);
        } catch (\Illuminate\Http\Exceptions\HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Datos de entrada no permitidos.'], 400);
        }
    }

    public function show($id)
    {
        $loan = $this->service->getLoan($id);
        if (!$loan) {
            return response()->json(['mensaje' => 'El préstamo no existe'], 404);
        }
        return response()->json([
            'id' => $loan->id,
            'isbn' => $loan->isbn,
            'identificacionUsuario' => $loan->identificacionUsuario,
            'tipoUsuario' => $loan->tipoUsuario,
            'fechaMaximaDevolucion' => $loan->fechaMaximaDevolucion,
        ]);
    }

    public function index()
    {
        $loans = $this->service->getAllLoans();
        return response()->json($loans);
    }

    public function byUser($id)
    {
        $loans = $this->service->getLoansByUser($id);
        return response()->json($loans);
    }
}
