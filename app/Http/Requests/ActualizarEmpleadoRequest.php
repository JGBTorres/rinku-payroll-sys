<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Empleado;

/**
 * Validación para actualizar empleados.
 */
class ActualizarEmpleadoRequest extends FormRequest
{
    public function rules(): array
    {
        // Obtener el ID real a partir del UUID
        $id = Empleado::where('uuid', $this->route('uuid'))->value('id');

        return [
            'numero_empleado' => "sometimes|string|unique:empleados,numero_empleado,{$id}",
            'nombre' => 'sometimes|string|max:255',
            'es_interno' => 'sometimes|boolean',
            'rol_id' => 'sometimes|exists:roles,id',
            'fecha_ingreso' => 'sometimes|date',
            'activo' => 'sometimes|boolean',
        ];
    }
}
