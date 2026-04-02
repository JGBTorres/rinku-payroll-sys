
import clienteAxios from '@/api/clientAxios';
import { Empleado } from '../Types';

export const empleadoService = {
    // Listar todos o buscar por número (?numero=123)
    listar: (numero?: string) =>
        clienteAxios.get(`/empleados${numero ? `?numero=${numero}` : ''}`),

    // Crear nuevo registro
    crear: (datos: Empleado) =>
        clienteAxios.post('/empleados', datos),

    // Actualizar usa el UUID en la URL
    actualizar: (uuid: string, datos: Partial<Empleado>) =>
        clienteAxios.put(`/empleados/${uuid}`, datos),

    // Eliminar (Baja lógica) usa el UUID
    eliminar: (uuid: string) =>
        clienteAxios.delete(`/empleados/${uuid}`),
};
