<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Movimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    //Registrar un nuevo movimiento
    public function guardar(Request $request)
    {
        $request->validate([
            'uuid'             => 'required|exists:empleados,uuid',
            'fecha'            => 'required|date',
            'horas_trabajadas' => 'required|numeric|min:1|max:24',
            'entregas'         => 'required|integer|min:0',
        ]);

        $empleado = Empleado::where('uuid', $request->uuid)->firstOrFail();

        $movimiento = Movimiento::create([
            'empleado_id'      => $empleado->id,
            'fecha'            => $request->fecha,
            'horas_trabajadas' => $request->horas_trabajadas,
            'entregas'         => $request->entregas,
            'rol_aplicado_id'  => $empleado->rol_id,
        ]);

        return response()->json(['mensaje' => 'Movimiento registrado', 'datos' => $movimiento], 201);
    }

    //Listar movimientos para ver su historial
    public function listar()
    {

        return response()->json(Movimiento::with('empleado:id,nombre,uuid')->get());
    }

    //Actualizar un movimiento existente (por ejemplo, si el empleado se equivocó al registrar sus horas o entregas)
    public function actualizar(Request $request, $id)
    {
        $movimiento = Movimiento::findOrFail($id);
        $movimiento->update($request->only(['fecha', 'horas_trabajadas', 'entregas']));

        return response()->json(['mensaje' => 'Movimiento actualizado', 'datos' => $movimiento]);
    }

    //Borrar un movimiento solo de forma lógica, para mantener el historial intacto
    public function eliminar($id)
    {
        $movimiento = Movimiento::findOrFail($id);

        //Solo llena la columna 'deleted_at' sin eliminar el registro físicamente
        $movimiento->delete();

        return response()->json(['mensaje' => 'Movimiento enviado eliminado']);
    }
}
