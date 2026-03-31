<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;




/**
 * Clase para estandarizar respuestas de la API.
 */
class ApiResponse
{
    public static function exito($datos = null, string $mensaje = 'Operación exitosa', int $codigo = 200): JsonResponse
    {
        return response()->json([
            'exito' => true,
            'mensaje' => $mensaje,
            'datos' => $datos
        ], $codigo);
    }

    public static function error(string $mensaje = 'Error en la operación', int $codigo = 400, $errores = null): JsonResponse
    {
        return response()->json([
            'exito' => false,
            'mensaje' => $mensaje,
            'errores' => $errores
        ], $codigo);
    }
}
