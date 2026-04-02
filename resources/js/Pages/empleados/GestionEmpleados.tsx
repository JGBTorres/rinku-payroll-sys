import React, { useState, useEffect } from 'react';
import { toast } from 'react-toastify';

import { useEmpleado } from '../../Hooks/useEmpleado';
import { empleadoService } from '../../Services/empleadoServicio';
import { CardRinku } from '../../Components/UI/CardRinku';
import { InputRinku } from '../../Components/UI/InputRinku';
import { BotonRinku } from '@/Components/UI/BotonRinku';
import { TablaEmpleados } from '@/Components/Empleados/TablaEmpleados';
import { FilaEmpleado } from '@/Components/Empleados/FilaEmpleado';
import { Empleado } from '../../Types'; // Importamos el tipo

const GestionEmpleados: React.FC = () => {
    const {
        form, handleChange, errors, guardar,
        setForm, initialForm, loading
    } = useEmpleado();

    const [empleados, setEmpleados] = useState<Empleado[]>([]);
    const [busqueda, setBusqueda] = useState('');

    const cargarEmpleados = async () => {
        try {
            const { data } = await empleadoService.listar();
            setEmpleados(data.datos || []);
        } catch (e) {
            toast.error("Error al conectar con la base de datos");
        }
    };

    useEffect(() => { cargarEmpleados(); }, []);

    // Manejador del guardado
    const handleGuardar = async () => {
        const exito = await guardar();
        if (exito) {
            cargarEmpleados();
        }
    };

    // Eliminar usa el UUID para coincidir con tu controlador
    const handleEliminar = async (uuid: string, numero: string) => {
        if (!window.confirm(`¿Confirmas la baja del empleado #${numero}?`)) return;
        try {
            const res = await empleadoService.eliminar(uuid);
            toast.success(res.data.mensaje || "Empleado desactivado");
            if (form.uuid === uuid) setForm(initialForm);
            cargarEmpleados();
        } catch (error: any) {
            toast.error(error.response?.data?.mensaje || "Error al eliminar");
        }
    };

    const editar = (emp: Empleado) => {
        setForm({
            ...emp,
            rol_id: emp.rol?.id || emp.rol_id,
            es_interno: emp.es_interno ? 1 : 0,
            // Aseguramos que la fecha sea compatible con el input type="date"
            fecha_ingreso: emp.fecha_ingreso || ''
        });
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    const isEditing = !!form.uuid;

    return (
        <div className="min-h-screen bg-[#f8fafc] p-4 md:p-10 space-y-10 antialiased font-sans">
            {/* 1. CABECERA */}
            <div className="max-w-6xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 className="text-3xl font-black text-slate-900 tracking-tight">
                        Sistema <span className="text-emerald-600">Rinku</span>
                    </h1>
                    <p className="text-slate-500 font-medium text-sm">Administración de Capital Humano</p>
                </div>
                <div className="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
                    <div className="h-10 w-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 font-bold">
                        {empleados.length}
                    </div>
                    <span className="pr-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Colaboradores</span>
                </div>
            </div>

            {/* 2. FORMULARIO */}
            <CardRinku
                titulo="Gestión de Personal"
                icono="👤"
                isEditing={isEditing}
                headerExtra={isEditing && (
                    <button onClick={() => setForm(initialForm)} className="bg-white text-blue-600 px-6 py-2 rounded-xl text-xs font-black hover:bg-blue-50 transition-all shadow-lg">
                        CANCELAR EDICIÓN
                    </button>
                )}
            >
                <div className="grid grid-cols-1 md:grid-cols-6 gap-8">
                    <InputRinku
                        label="ID Nómina" name="numero_empleado" colSpan="md:col-span-1"
                        value={form.numero_empleado} onChange={handleChange} error={errors.numero_empleado}
                    />
                    <InputRinku
                        label="Nombre Completo" name="nombre" colSpan="md:col-span-3"
                        value={form.nombre} onChange={handleChange} error={errors.nombre}
                    />

                    {/* NUEVO: Campo de Fecha de Ingreso */}
                    <InputRinku
                        label="Fecha de Ingreso" name="fecha_ingreso" type="date" colSpan="md:col-span-2"
                        value={form.fecha_ingreso || ''} onChange={handleChange} error={errors.fecha_ingreso}
                    />

                    {/* Selector de Puesto */}
                    <div className="md:col-span-3 space-y-3">
                        <label className="text-xs font-bold text-slate-500 uppercase tracking-widest text-center block">Puesto</label>
                        <div className="flex gap-2 bg-slate-100 p-1.5 rounded-2xl">
                            {['Chofer', 'Cargador', 'Auxiliar'].map((rol, i) => (
                                <button key={rol} type="button" onClick={() => handleChange({ target: { name: 'rol_id', value: i + 1 } } as any)}
                                    className={`flex-1 py-3 text-[10px] font-black uppercase rounded-xl transition-all ${Number(form.rol_id) === i + 1 ? 'bg-white shadow-md text-emerald-600' : 'text-slate-400'}`}>
                                    {rol}
                                </button>
                            ))}
                        </div>
                    </div>

                    {/* Selector de Modalidad */}
                    <div className="md:col-span-3 space-y-3">
                        <label className="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Modalidad de Contrato</label>
                        <div className="grid grid-cols-2 gap-4">
                            {[{ l: 'Interno (Directo)', v: 1 }, { l: 'Externo (Terceros)', v: 0 }].map((t) => (
                                <button key={t.v} type="button" onClick={() => handleChange({ target: { name: 'es_interno', value: t.v } } as any)}
                                    className={`p-4 text-left border-2 transition-all rounded-2xl ${Number(form.es_interno) === t.v ? 'border-emerald-500 bg-emerald-50' : 'border-slate-50 bg-slate-50'}`}>
                                    <div className={`text-xs font-black uppercase ${Number(form.es_interno) === t.v ? 'text-emerald-600' : 'text-slate-400'}`}>{t.l}</div>
                                </button>
                            ))}
                        </div>
                    </div>

                    <div className="md:col-span-6 flex justify-end">
                        <div className="w-full md:w-1/3">
                            <BotonRinku
                                onClick={handleGuardar}
                                loading={loading}
                                variant={isEditing ? 'blue' : 'emerald'}
                                label={isEditing ? 'Actualizar Datos' : 'Registrar Empleado'}
                            />
                        </div>
                    </div>
                </div>
            </CardRinku>

            {/* 3. LISTADO */}
            <TablaEmpleados onBusqueda={setBusqueda}>
                {empleados
                    .filter(e =>
                        e.nombre.toLowerCase().includes(busqueda.toLowerCase()) ||
                        e.numero_empleado.includes(busqueda)
                    )
                    .map((emp) => (
                        <FilaEmpleado
                            key={emp.uuid} // Usar UUID como key es más seguro
                            empleado={emp}
                            onEditar={editar}
                            // Pasamos tanto el uuid como el numero para el mensaje y la API
                            onEliminar={() => handleEliminar(emp.uuid!, emp.numero_empleado)}
                        />
                    ))
                }
            </TablaEmpleados>
        </div>
    );
};

export default GestionEmpleados;
