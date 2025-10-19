<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePetRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para actualizar una mascota.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Relación (no obligatoria en update)
            'owner_id' => ['sometimes', 'exists:users,id'],

            // Identificación básica
            'name' => ['sometimes', 'string', 'max:80'],
            'species' => ['sometimes', 'in:dog,cat,rabbit,bird,reptile,rodent,other'],
            'breed' => ['nullable', 'string', 'max:120'],
            'sex' => ['nullable', 'in:male,female,unknown'],
            'size' => ['nullable', 'in:toy,small,medium,large,giant'],
            'color' => ['nullable', 'string', 'max:80'],
            'birth_date' => ['nullable', 'date', 'before_or_equal:today'],
            'weight_kg' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'sterilized' => ['boolean'],

            // Documentos / medios
            'photo_path' => ['nullable', 'file', 'max:4096', 'mimes:jpg,jpeg,png,gif'],

            // Operación de guardería
            'status' => ['sometimes', 'in:active,inactive,banned'],
        ];
    }

    /**
     * Mensajes personalizados
     */
    public function messages(): array
    {
        return [
            'owner_id.exists' => 'El dueño seleccionado no existe.',
            'species.in' => 'La especie seleccionada no es válida.',
            'sex.in' => 'El sexo debe ser male, female o unknown.',
            'size.in' => 'El tamaño debe ser toy, small, medium, large o giant.',
            'photo_path.mimes' => 'La foto debe ser una imagen en formato jpg, jpeg, png o gif.',
            'photo_path.max' => 'La imagen no puede superar los 4 MB.',
        ];
    }
}
