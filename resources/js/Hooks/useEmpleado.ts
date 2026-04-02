import { useState } from 'react';
import { toast } from 'react-toastify';
import { empleadoService } from '../Services/empleadoServicio';
import { Empleado } from '../Types';

export const useEmpleado = () => {
    const initialForm: Empleado = {
        numero_empleado: '',
        nombre: '',
        rol_id: '',
        es_interno: 1,
        fecha_ingreso: new Date().toISOString().split('T')[0], // Hoy por defecto
    };

    const [form, setForm] = useState<Empleado>(initialForm);
    const [errors, setErrors] = useState<Record<string, any>>({});
    const [loading, setLoading] = useState(false);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        // Convertimos a número si es rol_id o es_interno
        const val = (name === 'rol_id' || name === 'es_interno') ? Number(value) : value;
        setForm({ ...form, [name]: val });
    };

    const guardar = async () => {
        setLoading(true);
        setErrors({});
        try {
            const res = form.uuid
                ? await empleadoService.actualizar(form.uuid, form)
                : await empleadoService.crear(form);

            toast.success(res.data.mensaje);
            setForm(initialForm);
            return true;
        } catch (error: any) {
            if (error.response?.status === 422) {
                setErrors(error.response.data.errors);
            }
            toast.error("Error al guardar");
            return false;
        } finally {
            setLoading(false);
        }
    };

    return { form, setForm, handleChange, guardar, errors, loading, initialForm };
};
