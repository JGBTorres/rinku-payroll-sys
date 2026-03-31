<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación para crear empleados.
 */
class CrearEmpleadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'numero_empleado' => 'required|string|unique:empleados,numero_empleado',
            'nombre' => 'required|string|max:255',
            'es_interno' => 'required|boolean',
            'rol_id' => 'required|exists:roles,id',
            'fecha_ingreso' => 'required|date',
        ];
    }
}
