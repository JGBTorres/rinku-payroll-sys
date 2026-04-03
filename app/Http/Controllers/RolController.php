<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class RolController extends Controller
{
    /**
     * Obtiene la lista de roles para el selector del frontend.
     */
    public function index(): JsonResponse
    {
        try {
            $roles = Rol::all();
            return ApiResponse::exito($roles, 'Roles recuperados correctamente');
        } catch (\Exception $e) {
            return ApiResponse::error('Error al obtener roles', 500);
        }
    }
}
