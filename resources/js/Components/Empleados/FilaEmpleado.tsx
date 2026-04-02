import React from 'react';
import { Empleado } from '../../Types';

interface FilaEmpleadoProps {
    empleado: Empleado;
    onEditar: (empleado: Empleado) => void;
    onEliminar: (uuid: string, numero: string) => void;
}

export const FilaEmpleado: React.FC<FilaEmpleadoProps> = ({ empleado, onEditar, onEliminar }) => {
    const esInactivo = !empleado.activo;

    return (
        <tr className={`group transition-all ${esInactivo ? 'bg-slate-50/40 opacity-75' : 'hover:bg-slate-50/50'}`}>
            {/* ID Nómina */}
            <td className="px-6 py-4 text-xs font-black text-slate-400 italic">
                {empleado.numero_empleado}
            </td>

            {/* Nombre */}
            <td className="px-6 py-4 text-sm font-bold text-slate-700">
                {empleado.nombre}
            </td>

            {/* Cargo */}
            <td className="px-6 py-4 text-center">
                <span className={`inline-block px-3 py-1 text-[9px] font-black uppercase rounded-lg border ${empleado.rol?.nombre === 'CHOFER'
                        ? 'bg-emerald-50 text-emerald-600 border-emerald-100'
                        : 'bg-sky-50 text-sky-600 border-sky-100'
                    }`}>
                    {empleado.rol?.nombre || 'AUXILIAR'}
                </span>
            </td>

            {/* Fecha Ingreso */}
            <td className="px-6 py-4 text-center">
                <span className="text-[10px] font-black text-slate-500 bg-white border border-slate-100 px-2 py-1 rounded-md shadow-sm">
                    {empleado.fecha_ingreso}
                </span>
            </td>

            {/* Estado Activo/Inactivo */}
            <td className="px-6 py-4 text-center">
                <span className={`inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-black uppercase border ${empleado.activo
                        ? 'bg-emerald-50 text-emerald-600 border-emerald-100'
                        : 'bg-rose-50 text-rose-600 border-rose-100'
                    }`}>
                    <span className={`h-1.5 w-1.5 rounded-full ${empleado.activo ? 'bg-emerald-500' : 'bg-rose-500'}`}></span>
                    {empleado.activo ? 'Activo' : 'Inactivo'}
                </span>
            </td>

            {/* Acciones con Bloqueo */}
            <td className="px-6 py-4 text-right">
                <div className="flex justify-end gap-2">
                    <button
                        onClick={() => !esInactivo && onEditar(empleado)}
                        disabled={!!esInactivo}
                        className={`p-2 rounded-xl transition-all ${esInactivo ? 'text-slate-200 cursor-not-allowed' : 'text-orange-500 hover:bg-orange-50'
                            }`}
                        title={esInactivo ? "No se puede editar" : "Editar colaborador"}
                    >
                        <span className="text-lg">✏️</span>
                    </button>
                    <button
                        onClick={() => !esInactivo && onEliminar(empleado.uuid!, empleado.numero_empleado)}
                        disabled={!!esInactivo}
                        className={`p-2 rounded-xl transition-all ${esInactivo ? 'text-slate-200 cursor-not-allowed' : 'text-slate-300 hover:text-red-500 hover:bg-red-50'
                            }`}
                        title={esInactivo ? "Ya está dado de baja" : "Dar de baja"}
                    >
                        <span className="text-lg">🗑️</span>
                    </button>
                </div>
            </td>
        </tr>
    );
};
