import React, { useState, useEffect } from 'react';
import { toast } from 'react-toastify';
import { useEmpleado } from '../../Hooks/useEmpleado';
import { empleadoService } from '../../Services/empleadoServicio';

const GestionEmpleados: React.FC = () => {
    const {
        form, handleChange, errors, ejecutarAccion, guardar,
        setForm, initialForm, loading
    } = useEmpleado();

    const [empleados, setEmpleados] = useState<any[]>([]);
    const [busqueda, setBusqueda] = useState('');

    //CARGAR LISTA
    const cargarEmpleados = async () => {
        try {
            const { data } = await empleadoService.listar();
            setEmpleados(data.datos || []);
        } catch (e) {
            toast.error("Error al conectar con la base de datos");
        }
    };

    useEffect(() => {
        cargarEmpleados();
    }, []);

    //GUARDAR / ACTUALIZAR
    const handleGuardar = async () => {
        await ejecutarAccion(guardar);
        cargarEmpleados();
    };

    //ELIMINAR (Baja Lógica)
    const handleEliminar = async (numero: string) => {
        if (!window.confirm(`¿Confirmas la baja del empleado #${numero}?`)) return;

        try {
            const res = await empleadoService.eliminar(numero);
            toast.success(res.data.mensaje || "Empleado desactivado");

            if (form.numero_empleado === numero) setForm(initialForm);
            cargarEmpleados();
        } catch (error: any) {
            toast.error(error.response?.data?.mensaje || "Error al eliminar");
        }
    };

    //EDICIÓN
    const editar = (emp: any) => {
        setForm({
            ...emp,
            rol_id: emp.rol?.id || emp.rol_id,
            es_interno: emp.es_interno ? 1 : 0
        });
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    const isEditing = !!form.uuid;
    const R_ESTANDAR = "rounded-2xl";

    return (
        <div className="min-h-screen bg-[#f8fafc] p-4 md:p-10 space-y-10 antialiased font-sans">

            {/* CABECERA */}
            <div className="max-w-6xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 className="text-3xl font-black text-slate-900 tracking-tight">
                        Sistema <span className="text-emerald-600">Rinku</span>
                    </h1>
                    <p className="text-slate-500 font-medium">Panel de Administración de Nómina</p>
                </div>
                <div className="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
                    <div className="h-10 w-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 font-bold">
                        {empleados.length}
                    </div>
                    <span className="pr-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Colaboradores</span>
                </div>
            </div>

            {/* FORMULARIO */}
            <div className={`max-w-6xl mx-auto bg-white ${R_ESTANDAR} shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden transition-all duration-500 ${isEditing ? 'ring-2 ring-blue-500 ring-offset-4' : ''}`}>
                <div className={`p-6 text-white flex justify-between items-center transition-colors duration-500 ${isEditing ? 'bg-blue-600' : 'bg-slate-900'}`}>
                    <div className="flex items-center gap-4">
                        <div className="h-12 w-12 bg-white/20 rounded-2xl flex items-center justify-center text-2xl">
                            {isEditing ? '📝' : '👤'}
                        </div>
                        <h2 className="text-lg font-bold uppercase tracking-tighter">
                            {isEditing ? 'Modificando Registro' : 'Nuevo Ingreso'}
                        </h2>
                    </div>
                    {isEditing && (
                        <button onClick={() => setForm(initialForm)} className="bg-white text-blue-600 px-6 py-2 rounded-xl text-xs font-black hover:bg-blue-50 transition-all shadow-lg">
                            CANCELAR EDICIÓN
                        </button>
                    )}
                </div>

                <div className="p-8 grid grid-cols-1 md:grid-cols-6 gap-8">
                    <div className="md:col-span-1 space-y-3">
                        <label className="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">ID</label>
                        <input name="numero_empleado" value={form.numero_empleado} onChange={handleChange} placeholder="000"
                            className={`w-full h-14 px-5 text-lg font-bold border-2 transition-all outline-none ${R_ESTANDAR} ${errors.numero_empleado ? 'border-red-200 bg-red-50 text-red-600' : 'border-slate-50 bg-slate-50 focus:bg-white focus:border-emerald-500 text-slate-700'}`} />
                    </div>

                    <div className="md:col-span-3 space-y-3">
                        <label className="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Nombre Completo</label>
                        <input name="nombre" value={form.nombre} onChange={handleChange} placeholder="Ej. Juan Pérez"
                            className={`w-full h-14 px-5 text-lg font-medium border-2 transition-all outline-none ${R_ESTANDAR} ${errors.nombre ? 'border-red-200 bg-red-50' : 'border-slate-50 bg-slate-50 focus:bg-white focus:border-emerald-500 text-slate-700'}`} />
                    </div>

                    <div className="md:col-span-2 space-y-3">
                        <label className="text-xs font-bold text-slate-500 uppercase tracking-widest text-center block">Puesto</label>
                        <div className="flex gap-2 bg-slate-100 p-1.5 rounded-2xl">
                            {['Chofer', 'Cargador', 'Auxiliar'].map((rol, i) => (
                                <button key={rol} onClick={() => handleChange({ target: { name: 'rol_id', value: i + 1 } } as any)}
                                    className={`flex-1 py-3 text-[10px] font-black uppercase rounded-xl transition-all ${Number(form.rol_id) === i + 1 ? 'bg-white shadow-md text-emerald-600' : 'text-slate-400'}`}>
                                    {rol}
                                </button>
                            ))}
                        </div>
                    </div>

                    <div className="md:col-span-3 space-y-3">
                        <label className="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Modalidad</label>
                        <div className="grid grid-cols-2 gap-4">
                            {[{ l: 'Interno', v: 1 }, { l: 'Externo', v: 0 }].map((t) => (
                                <button key={t.v} onClick={() => handleChange({ target: { name: 'es_interno', value: t.v } } as any)}
                                    className={`p-4 text-left border-2 transition-all ${R_ESTANDAR} ${Number(form.es_interno) === t.v ? 'border-emerald-500 bg-emerald-50' : 'border-slate-50 bg-slate-50'}`}>
                                    <div className={`text-xs font-black uppercase ${Number(form.es_interno) === t.v ? 'text-emerald-600' : 'text-slate-400'}`}>{t.l}</div>
                                </button>
                            ))}
                        </div>
                    </div>

                    <div className="md:col-span-3 flex items-end">
                        <button onClick={handleGuardar} disabled={loading}
                            className={`w-full h-14 ${isEditing ? 'bg-blue-600' : 'bg-emerald-600'} text-white font-black uppercase text-sm tracking-widest shadow-xl hover:translate-y-[-2px] active:scale-95 transition-all ${R_ESTANDAR}`}>
                            {loading ? 'Procesando...' : (isEditing ? 'Confirmar Cambios' : 'Guardar Empleado')}
                        </button>
                    </div>
                </div>
            </div>

            {/* TABLA */}
            <div className="max-w-6xl mx-auto bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden">
                <div className="p-8 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center gap-6 bg-slate-50/30">
                    <h2 className="font-black text-slate-800 text-sm uppercase tracking-widest text-center md:text-left">Listado General de Empleados</h2>
                    <input type="text" placeholder="Buscar por ID o Nombre..."
                        className="w-full md:w-96 bg-white border-2 border-slate-100 rounded-2xl px-5 py-3 text-sm outline-none focus:border-emerald-500 shadow-sm"
                        onChange={(e) => setBusqueda(e.target.value)} />
                </div>

                <div className="overflow-x-auto px-4 pb-4">
                    <table className="w-full text-left">
                        <thead>
                            <tr className="text-[10px] uppercase font-black text-slate-400 tracking-widest">
                                <th className="p-6">ID Nómina</th>
                                <th className="p-6">Información Empleado</th>
                                <th className="p-6">Cargo</th>
                                <th className="p-6 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-slate-50">
                            {empleados
                                .filter(e => e.nombre.toLowerCase().includes(busqueda.toLowerCase()) || e.numero_empleado.includes(busqueda))
                                .map((emp) => {
                                    const isInactivo = emp.activo === 0 || emp.activo === false;

                                    return (
                                        <tr key={emp.id} className={`transition-all group ${isInactivo ? 'bg-slate-50 opacity-60' : 'hover:bg-slate-50/80'}`}>
                                            <td className="p-6">
                                                <span className={`px-3 py-2 rounded-xl font-black text-xs ${isInactivo ? 'bg-slate-200 text-slate-400' : 'bg-slate-100 text-slate-600'}`}>
                                                    #{emp.numero_empleado}
                                                </span>
                                            </td>
                                            <td className="p-6">
                                                <div className={`font-bold ${isInactivo ? 'text-slate-400' : 'text-slate-800'}`}>{emp.nombre}</div>
                                                <div className="flex items-center gap-2 mt-1">
                                                    <span className="text-[10px] font-bold uppercase text-slate-400">{emp.es_interno ? 'Directo' : 'Externo'}</span>
                                                    {isInactivo && (
                                                        <span className="bg-red-100 text-red-600 text-[9px] px-2 py-0.5 rounded font-black uppercase">INACTIVO</span>
                                                    )}
                                                </div>
                                            </td>
                                            <td className="p-6">
                                                <span className={`px-4 py-1.5 rounded-xl text-[10px] font-black uppercase ${isInactivo ? 'bg-slate-100 text-slate-300' : 'bg-blue-50 text-blue-600'}`}>
                                                    {emp.rol?.nombre || 'Sin Rol'}
                                                </span>
                                            </td>
                                            <td className="p-6">
                                                <div className="flex justify-center gap-2">
                                                    <button
                                                        onClick={() => !isInactivo && editar(emp)}
                                                        disabled={isInactivo}
                                                        className={`h-10 px-4 rounded-xl text-[10px] font-black uppercase transition-all shadow-sm ${isInactivo
                                                            ? 'bg-transparent text-slate-300 border border-slate-100 cursor-not-allowed'
                                                            : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-900 hover:text-white'
                                                            }`}>
                                                        {isInactivo ? 'Bloqueado' : 'Editar'}
                                                    </button>

                                                    {!isInactivo && (
                                                        <button
                                                            onClick={() => handleEliminar(emp.numero_empleado)}
                                                            className="h-10 w-10 bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all flex items-center justify-center text-xs shadow-sm"
                                                            title="Dar de baja">
                                                            ✕
                                                        </button>
                                                    )}
                                                </div>
                                            </td>
                                        </tr>
                                    );
                                })}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
};

export default GestionEmpleados;
