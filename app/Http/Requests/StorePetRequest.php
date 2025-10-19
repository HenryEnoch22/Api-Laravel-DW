<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para almacenar una mascota.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Relación
            'owner_id' => ['required', 'exists:users,id'],

            // Identificación básica
            'name' => ['required', 'string', 'max:80'],
            'species' => ['required', 'in:dog,cat,rabbit,bird,reptile,rodent,other'],
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
//            'status' => ['nullable', 'in:active,inactive,banned'],
//            'admission_date' => ['nullable', 'date'],
        ];
    }

    /**
     * Mensajes personalizados (opcional pero recomendado)
     */
    public function messages(): array
    {
        return [
            'owner_id.required' => 'Debes indicar el dueño de la mascota.',
            'owner_id.exists' => 'El dueño seleccionado no existe.',
            'name.required' => 'El nombre de la mascota es obligatorio.',
            'species.required' => 'Debes especificar la especie.',
            'species.in' => 'La especie seleccionada no es válida.',
        ];
    }
}
