<?php

namespace App\Domain\Services;

use App\Domain\Repositories\PrestamoRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;

class PrestamoService
{
    public function __construct(private PrestamoRepositoryInterface $repository) {}

    public function createLoan(array $data)
    {
        if ($data['tipoUsuario'] == 3 && $this->repository->userHasLoan($data['identificacionUsuario'])) {
            throw new HttpResponseException(response()->json(['mensaje' => 'El usuario ya tiene un libro prestado'], 400));
        }

        $returnDate = $this->calculateReturnDate((int)$data['tipoUsuario']);
        $payload = [
            'isbn' => $data['isbn'],
            'identificacionUsuario' => $data['identificacionUsuario'],
            'tipoUsuario' => $data['tipoUsuario'],
            'fechaMaximaDevolucion' => $returnDate
        ];

        return $this->repository->create($payload);
    }

    public function getLoan(string $id)
    {
        return $this->repository->find($id);
    }

    public function getAllLoans()
    {
        return $this->repository->getAll();
    }

    public function getLoansByUser(string $userId)
    {
        return $this->repository->getByUser($userId);
    }

    private function calculateReturnDate(int $type): string
    {
        $days = match ($type) {
            1 => 10,
            2 => 8,
            3 => 7,
            default => 7,
        };

        $date = \Carbon\Carbon::now();
        $added = 0;
        while ($added < $days) {
            $date = $date->addDay();
            if (!in_array($date->dayOfWeekIso, [6, 7])) {
                $added++;
            }
        }
        return $date->toDateString();
    }
}
