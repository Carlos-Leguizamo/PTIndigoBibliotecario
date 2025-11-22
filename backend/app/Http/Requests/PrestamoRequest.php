<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrestamoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'isbn' => 'required|string',
            'identificacionUsuario' => 'required|alpha_num|max:10',
            'tipoUsuario' => 'required|integer|in:1,2,3'
        ];
    }
    public function messages(): array
    {
        return [
            'isbn.required' => 'El campo ISBN es obligatorio.',
            'isbn.string' => 'El campo ISBN debe ser una cadena de texto.',
            'identificacionUsuario.required' => 'La identificación del usuario es obligatoria.',
            'identificacionUsuario.alpha_num' => 'La identificación del usuario debe ser alfanumérica.',
            'identificacionUsuario.max' => 'La identificación del usuario no debe superar los 10 caracteres.',
            'tipoUsuario.required' => 'El tipo de usuario es obligatorio.',
            'tipoUsuario.integer' => 'El tipo de usuario debe ser un número.',
            'tipoUsuario.in' => 'El tipo de usuario debe ser 1, 2 o 3.'
        ];
    }
}
