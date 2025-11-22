<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Prestamo;

class LoanTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_loan_success()
    {
        $user = User::factory()->create();
        $payload = [
            'isbn' => '1234567890',
            'identificacionUsuario' => 'USER123',
            'tipoUsuario' => 1
        ];
        $response = $this->actingAs($user)->postJson('/api/prestamo', $payload);
        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'returnDate']);
    }

    public function test_guest_user_cannot_have_multiple_loans()
    {
        $user = User::factory()->create();
        Prestamo::create([
            'isbn' => '1111111111',
            'identificacionUsuario' => 'INVITADO1',
            'tipoUsuario' => 3,
            'fechaMaximaDevolucion' => now()->addDays(7)
        ]);
        $payload = [
            'isbn' => '2222222222',
            'identificacionUsuario' => 'INVITADO1',
            'tipoUsuario' => 3
        ];
        $response = $this->actingAs($user)->postJson('/api/prestamo', $payload);
        $response->assertStatus(400)
            ->assertJson(['mensaje' => 'El usuario ya tiene un libro prestado']);
    }

    public function test_invalid_fields_return_400()
    {
        $user = User::factory()->create();
        $payload = [
            'isbn' => '',
            'identificacionUsuario' => 'TOOLONGIDENTIFICACION123',
            'tipoUsuario' => 5
        ];
        $response = $this->actingAs($user)->postJson('/api/prestamo', $payload);
        $response->assertStatus(400);
    }

    public function test_get_nonexistent_loan_returns_404()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/prestamo/invalid-id');
        $response->assertStatus(404)
            ->assertJson(['mensaje' => 'El préstamo no existe']);
    }
}
