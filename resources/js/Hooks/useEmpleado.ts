import { useState } from 'react';
import { toast } from 'react-toastify';
import { empleadoService } from "../Services/empleadoServicio";
import { Empleado } from '../Types';

export const useEmpleado = () => {
    const initialForm: Empleado = {
        numero_empleado: '',
        nombre: '',
        rol_id: '',
        es_interno: 1,
        activo: true,
    };

    const [form, setForm] = useState<Empleado>(initialForm);
    const [errors, setErrors] = useState<Record<string, string>>({});
    const [loading, setLoading] = useState(false);

    const handleChange = (e: any) => {
        const { name, value } = e.target;
        setForm(prev => ({ ...prev, [name]: value }));
        if (errors[name]) setErrors(prev => ({ ...prev, [name]: '' }));
    };

    const validarIdentidad = async (numero: string, modo: string) => {
        if (!numero || loading) return;
        setErrors({});
        setLoading(true);

        try {
            const { data } = await empleadoService.buscar(numero, modo === 'nuevo');

            if (data.datos && modo !== 'nuevo') {
                // CORRECCIÓN CLAVE: Mapeamos los datos para la interfaz
                const empleadoMapeado = {
                    ...data.datos,
                    // Si viene el objeto 'rol', extraemos su ID para que el botón se marque
                    rol_id: data.datos.rol ? data.datos.rol.id : data.datos.rol_id,
                    // Convertimos el booleano 'es_interno' a 1 o 0 para los botones
                    es_interno: data.datos.es_interno ? 1 : 0
                };

                setForm(empleadoMapeado);

                // Si el usuario picó en el botón azul de CONSULTAR
                if (modo === 'buscar') {
                    toast.success(data.mensaje || "Empleado encontrado");
                }
            }
        } catch (error: any) {
            setErrors({ numero_empleado: error.response?.data?.mensaje || "Error" });
            if (modo !== 'nuevo') {
                setForm(prev => ({ ...initialForm, numero_empleado: numero }));
            }
        } finally {
            setLoading(false);
        }
    };

    const guardar = async () => {
        const payload = { ...form, fecha_ingreso: new Date().toISOString().split('T')[0] };
        return form.uuid ? empleadoService.actualizar(form.uuid, payload) : empleadoService.crear(payload);
    };

    const desactivar = async () => {
        return empleadoService.eliminar(form.numero_empleado);
    };

    const ejecutarAccion = async (accion: () => Promise<any>) => {
        if (loading) return;
        setLoading(true);
        try {
            const res = await accion();
            toast.success(res.data?.mensaje || "Éxito");
            setForm(initialForm);
            setErrors({});
        } catch (error: any) {
            toast.error(error.response?.data?.mensaje || "Error en la operación");
            if (error.response?.status === 422) setErrors(error.response.data.errors || {});
        } finally {
            setLoading(false);
        }
    };

    return {
        form, handleChange, setForm, initialForm, errors, setErrors,
        validarIdentidad, ejecutarAccion, guardar, desactivar, loading
    };
};
