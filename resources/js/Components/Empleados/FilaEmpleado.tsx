import React from 'react';

interface FilaEmpleadoProps {
    empleado: any;
    onEditar: (emp: any) => void;
    onEliminar: (numero: string) => void;
}

export const FilaEmpleado: React.FC<FilaEmpleadoProps> = ({ empleado, onEditar, onEliminar }) => {
    const isInactivo = empleado.activo === 0 || empleado.activo === false;

    return (
        <tr className={`transition-all group ${isInactivo ? 'bg-slate-50 opacity-60' : 'hover:bg-slate-50/80'}`}>
            <td className="p-6">
                <span className={`px-3 py-2 rounded-xl font-black text-xs ${isInactivo ? 'bg-slate-200 text-slate-400' : 'bg-slate-100 text-slate-600'}`}>
                    #{empleado.numero_empleado}
                </span>
            </td>
            <td className="p-6">
                <div className={`font-bold ${isInactivo ? 'text-slate-400' : 'text-slate-800'}`}>{empleado.nombre}</div>
                <div className="flex items-center gap-2 mt-1">
                    <span className="text-[10px] font-bold uppercase text-slate-400">
                        {empleado.es_interno ? 'Directo' : 'Externo'}
                    </span>
                    {isInactivo && (
                        <span className="bg-red-100 text-red-600 text-[9px] px-2 py-0.5 rounded font-black uppercase">
                            Inactivo
                        </span>
                    )}
                </div>
            </td>
            <td className="p-6">
                <span className={`px-4 py-1.5 rounded-xl text-[10px] font-black uppercase ${isInactivo ? 'bg-slate-100 text-slate-300' : 'bg-blue-50 text-blue-600'}`}>
                    {empleado.rol?.nombre || 'Sin Rol'}
                </span>
            </td>
            <td className="p-6 text-center">
                <div className="flex justify-center gap-2">
                    <button
                        onClick={() => !isInactivo && onEditar(empleado)}
                        disabled={isInactivo}
                        className={`h-10 px-4 rounded-xl text-[10px] font-black uppercase transition-all shadow-sm ${isInactivo
                                ? 'bg-transparent text-slate-300 border border-slate-100'
                                : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-900 hover:text-white'
                            }`}
                    >
                        {isInactivo ? 'Bloqueado' : 'Editar'}
                    </button>
                    {!isInactivo && (
                        <button
                            onClick={() => onEliminar(empleado.numero_empleado)}
                            className="h-10 w-10 bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all flex items-center justify-center text-xs shadow-sm"
                        >
                            ✕
                        </button>
                    )}
                </div>
            </td>
        </tr>
    );
};
