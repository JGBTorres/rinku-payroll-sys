<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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


    public function messages(): array
    {
        return [
            'numero_empleado.unique' => 'El número de empleado ya existe.',
            'rol_id.exists' => 'El rol seleccionado no es válido.',
            'fecha_ingreso.date' => 'El formato de fecha es incorrecto.',
        ];
    }
}
