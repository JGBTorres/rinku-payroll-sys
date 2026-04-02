import React from 'react';

interface TablaEmpleadosProps {
    children: React.ReactNode;
    onBusqueda: (valor: string) => void;
}

export const TablaEmpleados: React.FC<TablaEmpleadosProps> = ({ children, onBusqueda }) => (
    <div className="max-w-6xl mx-auto bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden">
        <div className="p-8 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center gap-6 bg-slate-50/30">
            <h2 className="font-black text-slate-800 text-sm uppercase tracking-widest">
                Listado General de Empleados
            </h2>
            <input
                type="text"
                placeholder="Buscar por ID o Nombre..."
                className="w-full md:w-96 bg-white border-2 border-slate-100 rounded-2xl px-5 py-3 text-sm outline-none focus:border-emerald-500 shadow-sm"
                onChange={(e) => onBusqueda(e.target.value)}
            />
        </div>

        <div className="overflow-x-auto px-4 pb-4">
            <table className="w-full text-left border-separate border-spacing-y-2">
                <thead>
                    <tr className="text-[10px] uppercase font-black text-slate-400 tracking-widest">
                        <th className="px-6 py-4">ID Nómina</th>
                        <th className="px-6 py-4">Información Empleado</th>
                        <th className="px-6 py-4 text-center">Cargo</th>
                        <th className="px-6 py-4 text-center">Ingreso</th>
                        <th className="px-6 py-4 text-center">Estado</th>
                        <th className="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody className="divide-y divide-slate-50">
                    {children}
                </tbody>
            </table>
        </div>
    </div>
);
